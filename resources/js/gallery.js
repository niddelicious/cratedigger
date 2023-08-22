var galleryButtons = document.getElementsByClassName("galleryButton");

var viewImage = function () {
    toggleInfo('hide');
    imgUrl = this.getAttribute("data-image");
    const viewer = document.querySelector('#viewer');
    const download = viewer.querySelector('#downloadButton');
    const info = viewer.querySelector('#infoButton');
    const image = viewer.querySelector('#image');
    const lossy = imgUrl.replace('sd-thumbs', 'sd-lossy');
    const orig = imgUrl.replace('sd-thumbs', 'sd-img').replace('.jpg', '.png');
    image.src = lossy;
    download.setAttribute('data-link', orig);
    info.setAttribute('data-image', orig);
};

Array.from(galleryButtons).forEach(function (galleryButton) {
    galleryButton.addEventListener('click', viewImage);
});

var toggleInfo = function (force) {
    if (force === 'hide') {
        imageInfo.style.display = "none";
        return;
    }
    if (force === 'show') {
        imageInfo.style.display = "flex";
        return;
    }
};

var viewImageInfo = function () {
    toggleInfo('show');
    document.querySelector('#prompt').textContent = "fetching...";
    document.querySelector('#negative_prompt').textContent = "fetching...";
    document.querySelector('#steps').textContent = "fetching...";
    document.querySelector('#model').textContent = "fetching...";
    document.querySelector('#seed').textContent = "fetching...";
    imgUrl = this.getAttribute("data-image");
    var xhr = new XMLHttpRequest();
    xhr.open('GET', imgUrl, true);
    xhr.responseType = 'arraybuffer';

    xhr.onload = function () {
        if (this.status === 200) {
            var data = new Uint8Array(this.response);
            var chunks = extractChunks(data);
            const textChunks = chunks.filter(function (chunk) {
                return chunk.name === 'tEXt'
            }).map(function (chunk) {
                return decode(chunk.data)
            })
            // Assuming your input text is stored in the variable 'text'
            let sd_text = textChunks[0]["text"];

            // Split the text by newline first
            let lines = sd_text.split('\n');

            // Initializations
            let prompt, negativePrompt, steps, model, seed;

            // The first line is the positive prompt
            prompt = lines[0];

            // The second line starts with "Negative prompt"
            if (lines[1].startsWith("Negative prompt: ")) {
                negativePrompt = lines[1].replace("Negative prompt: ", "");
            }

            // The rest of the parameters are in the third line, separated by commas
            let params = lines[2].split(', ');

            for (let param of params) {
                if (param.startsWith("Steps: ")) {
                    steps = param.replace("Steps: ", "");
                } else if (param.startsWith("Model: ")) {
                    model = param.replace("Model: ", "");
                } else if (param.startsWith("Seed: ")) {
                    seed = param.replace("Seed: ", "");
                }
            }

            // Log the extracted values
            console.log("Prompt: ", prompt);
            console.log("Negative prompt: ", negativePrompt);
            console.log("Steps: ", steps);
            console.log("Model: ", model);
            console.log("Seed: ", seed);
            document.querySelector('#prompt').textContent = prompt;
            document.querySelector('#negative_prompt').textContent = negativePrompt;
            document.querySelector('#steps').textContent = steps;
            document.querySelector('#model').textContent = model;
            document.querySelector('#seed').textContent = seed;



        }
    };

    xhr.send();

};

var crc32 = require('crc-32')
var uint8 = new Uint8Array(4)
var int32 = new Int32Array(uint8.buffer)
var uint32 = new Uint32Array(uint8.buffer)

function extractChunks(data) {
    if (data[0] !== 0x89) throw new Error('Invalid .png file header')
    if (data[1] !== 0x50) throw new Error('Invalid .png file header')
    if (data[2] !== 0x4E) throw new Error('Invalid .png file header')
    if (data[3] !== 0x47) throw new Error('Invalid .png file header')
    if (data[4] !== 0x0D) throw new Error('Invalid .png file header: possibly caused by DOS-Unix line ending conversion?')
    if (data[5] !== 0x0A) throw new Error('Invalid .png file header: possibly caused by DOS-Unix line ending conversion?')
    if (data[6] !== 0x1A) throw new Error('Invalid .png file header')
    if (data[7] !== 0x0A) throw new Error('Invalid .png file header: possibly caused by DOS-Unix line ending conversion?')

    var ended = false
    var chunks = []
    var idx = 8

    while (idx < data.length) {
        // Read the length of the current chunk,
        // which is stored as a Uint32.
        uint8[3] = data[idx++]
        uint8[2] = data[idx++]
        uint8[1] = data[idx++]
        uint8[0] = data[idx++]

        // Chunk includes name/type for CRC check (see below).
        var length = uint32[0] + 4
        var chunk = new Uint8Array(length)
        chunk[0] = data[idx++]
        chunk[1] = data[idx++]
        chunk[2] = data[idx++]
        chunk[3] = data[idx++]

        // Get the name in ASCII for identification.
        var name = (
            String.fromCharCode(chunk[0]) +
            String.fromCharCode(chunk[1]) +
            String.fromCharCode(chunk[2]) +
            String.fromCharCode(chunk[3])
        )

        // The IHDR header MUST come first.
        if (!chunks.length && name !== 'IHDR') {
            throw new Error('IHDR header missing')
        }

        // The IEND header marks the end of the file,
        // so on discovering it break out of the loop.
        if (name === 'IEND') {
            ended = true
            chunks.push({
                name: name,
                data: new Uint8Array(0)
            })

            break
        }

        // Read the contents of the chunk out of the main buffer.
        for (var i = 4; i < length; i++) {
            chunk[i] = data[idx++]
        }

        // Read out the CRC value for comparison.
        // It's stored as an Int32.
        uint8[3] = data[idx++]
        uint8[2] = data[idx++]
        uint8[1] = data[idx++]
        uint8[0] = data[idx++]

        var crcActual = int32[0]
        var crcExpect = crc32.buf(chunk)
        if (crcExpect !== crcActual) {
            throw new Error(
                'CRC values for ' + name + ' header do not match, PNG file is likely corrupted'
            )
        }

        // The chunk data is now copied to remove the 4 preceding
        // bytes used for the chunk name/type.
        var chunkData = new Uint8Array(chunk.buffer.slice(4))

        chunks.push({
            name: name,
            data: chunkData
        })
    }

    if (!ended) {
        throw new Error('.png file ended prematurely: no IEND header was found')
    }

    return chunks
}

function decode(data) {
    if (data.data && data.name) {
        data = data.data
    }

    var naming = true
    var text = ''
    var name = ''

    for (var i = 0; i < data.length; i++) {
        var code = data[i]

        if (naming) {
            if (code) {
                name += String.fromCharCode(code)
            } else {
                naming = false
            }
        } else {
            if (code) {
                text += String.fromCharCode(code)
            } else {
                throw new Error('Invalid NULL character found. 0x00 character is not permitted in tEXt content')
            }
        }
    }

    return {
        keyword: name,
        text: text
    }
}


var infoButton = document.getElementById('infoButton');
var downloadButton = document.getElementById('downloadButton');
var imageInfo = document.getElementById('sd-info');

infoButton.addEventListener('click', viewImageInfo);
downloadButton.addEventListener('click', function () {
    var url = downloadButton.getAttribute('data-link');
    window.open(url, '_blank');
    window.focus();
});
imageInfo.addEventListener('click', function () {
    toggleInfo('hide');
});
