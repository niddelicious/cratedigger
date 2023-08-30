var galleryButtons = document.getElementsByClassName("galleryButton");

var viewImage = function () {
    toggleInfo('hide');
    imgUrl = this.getAttribute("data-image");
    const viewer = document.querySelector('#viewer');
    const download = viewer.querySelector('#downloadButton');
    const info = viewer.querySelector('#infoButton');
    const image = viewer.querySelector('#image');
    var lossy = imgUrl.replace('sd-thumbs', 'sd-lossy');
    var orig = imgUrl.replace('sd-thumbs', 'sd-img').replace('.jpg', '.png');
    var image_id = imgUrl.replace('storage/sd-thumbs/', '').replace('.jpg', '');
    image.src = '/' + lossy;
    download.setAttribute('data-link', orig);
    info.setAttribute('data-image', orig);
    history.pushState(null, null, '/gallery/' + image_id);
    fetchImageInfo(orig);
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

var fetchImageInfo = function (imgUrl) {
    document.querySelector('#image-prompt').textContent = "fetching...";
    document.querySelector('#prompt').textContent = "fetching...";
    document.querySelector('#negative_prompt').textContent = "fetching...";
    document.querySelector('#steps').textContent = "fetching...";
    document.querySelector('#model').textContent = "fetching...";
    document.querySelector('#seed').textContent = "fetching...";
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/' + imgUrl, true);
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
            let sd_text = textChunks[0]["text"];
            let lines = sd_text.split('\n');
            let prompt, negativePrompt, steps, model, seed;
            prompt = lines[0];
            if (lines[1].startsWith("Negative prompt: ")) {
                negativePrompt = lines[1].replace("Negative prompt: ", "");
            }
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

            document.querySelector('#prompt').textContent = prompt;
            document.querySelector('#negative_prompt').textContent = negativePrompt;
            document.querySelector('#steps').textContent = steps;
            document.querySelector('#model').textContent = model;
            document.querySelector('#seed').textContent = seed;
            var image_prompt = cleanPrompt(prompt);
            document.querySelector('#image-prompt').textContent = image_prompt;
        }
    };

    xhr.send();
};

var viewImageInfo = function () {
    toggleInfo('show');
    document.querySelector('#image-prompt').textContent = "fetching...";
    document.querySelector('#prompt').textContent = "fetching...";
    document.querySelector('#negative_prompt').textContent = "fetching...";
    document.querySelector('#steps').textContent = "fetching...";
    document.querySelector('#model').textContent = "fetching...";
    document.querySelector('#seed').textContent = "fetching...";
    imgUrl = '/' + this.getAttribute("data-image");
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

            document.querySelector('#prompt').textContent = prompt;
            document.querySelector('#negative_prompt').textContent = negativePrompt;
            document.querySelector('#steps').textContent = steps;
            document.querySelector('#model').textContent = model;
            document.querySelector('#seed').textContent = seed;
            var image_prompt = cleanPrompt(prompt);
            document.querySelector('#image-prompt').textContent = image_prompt;
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

const styles = {
    "Ghibli": "(Studio ghibli style, Art by Hayao Miyazaki:1.2), Anime Style, Manga Style, Hand drawn, cinematic, Sharp focus, humorous illustration, big depth of field, Masterpiece, concept art, trending on artstation, Vivid colors, Simplified style, trending on ArtStation, trending on CGSociety, Intricate, Vibrant colors, Soft Shading, Simplistic Features, Sharp Angles, Playful",
    "Vector Illustrations": "Vector art, Vivid colors, Clean lines, Sharp edges, Minimalist, Precise geometry, Simplistic, Smooth curves, Bold outlines, Crisp shapes, Flat colors, Illustration art piece, High contrast shadows, Technical illustration, Graphic design, Vector graphics, High contrast, Precision artwork, Linear compositions, Scalable artwork, Digital art",
    "Digital/Oil Painting": "(Extremely Detailed Oil Painting:1.2), glow effects, godrays, Hand drawn, render, 8k, octane render, cinema 4d, blender, dark, atmospheric 4k ultra detailed, cinematic sensual, Sharp focus, humorous illustration, big depth of field, Masterpiece, colors, 3d octane render, 4k, concept art, trending on artstation, hyperrealistic, Vivid colors, extremely detailed CG unity 8k wallpaper, trending on ArtStation, trending on CGSociety, Intricate, High Detail, dramatic, absurdes",
    "Indie Game": "Indie game art,({prompt}), (Vector Art, Borderlands style, Arcane style, Cartoon style), Line art, Disctinct features, Hand drawn, Technical illustration, Graphic design, Vector graphics, High contrast, Precision artwork, Linear compositions, Scalable artwork, Digital art, cinematic sensual, Sharp focus, humorous illustration, big depth of field, Masterpiece, trending on artstation, Vivid colors, trending on ArtStation, trending on CGSociety, Intricate, Low Detail, dramatic",
    "Original Photo Style": "Photorealistic, Hyperrealistic, Hyperdetailed, analog style, detailed skin, matte skin, soft lighting, subsurface scattering, realistic, heavy shadow, masterpiece, best quality, ultra realistic, 8k, golden ratio, Intricate, High Detail, film photography, soft focus",
    "Black and White Film Noir": "(b&w, Monochromatic, Film Photography:1.3),  Photorealistic, Hyperrealistic, Hyperdetailed, film noir, analog style, soft lighting, subsurface scattering, realistic, heavy shadow, masterpiece, best quality, ultra realistic, 8k, golden ratio, Intricate, High Detail, film photography, soft focus",
    "Isometric Rooms": "Tiny cute isometric {prompt} in a cutaway box, soft smooth lighting, soft colors, 100mm lens, 3d blender render",
    "Space Hologram": "hologram of {prompt} floating in space, a vibrant digital illustration, dribbble, quantum wavetracing, black background, behance hd",
    "Cute Creatures": "3d fluffy {prompt}, closeup cute and adorable, cute big circular reflective eyes, long fuzzy fur, Pixar render, unreal engine cinematic smooth, intricate detail, cinematic",
    "Realistic Photo Portraits": "RAW candid cinema, 16mm, color graded portra 400 film, remarkable color, ultra realistic, textured skin, remarkable detailed pupils, realistic dull skin noise, visible skin detail, skin fuzz, dry skin, shot with cinematic camera",
    "Professional Scenic Photographs": "long shot scenic professional photograph of {prompt}, perfect viewpoint, highly detailed, wide-angle lens, hyper realistic, with dramatic sky, polarizing filter, natural lighting, vivid colors, everything in sharp focus, HDR, UHD, 64K",
    "Manga": "(Manga Style, Yusuke Murata, Satoshi Kon, Ken Sugimori, Hiromu Arakawa), Pencil drawing, (B&W:1.2), Low detail, sketch, concept art, Anime style, line art, webtoon, manhua, chalk, hand drawn, defined lines, simple shades, simplistic, manga page, minimalistic, High contrast, Precision artwork, Linear compositions, Scalable artwork, Digital art, High Contrast Shadows",
    "Anime": "(Anime Scene, Toonshading, Satoshi Kon, Ken Sugimori, Hiromu Arakawa:1.2), (Anime Style, Manga Style:1.3), Low detail, sketch, concept art, line art, webtoon, manhua, hand drawn, defined lines, simple shades, minimalistic, High contrast, Linear compositions, Scalable artwork, Digital art, High Contrast Shadows, glow effects, humorous illustration, big depth of field, Masterpiece, colors, concept art, trending on artstation, Vivid colors, dramatic",
};
const broken_styles = [
    "(Studio ghibli style, Art by Hayao Miyazaki:1.2), Anime Style, Manga Style, Hand drawn, cinematic, Sharp focus, humorous illustration, big depth of field, Masterpiece, concept art, trending on artstation, Vivid colors, Simplified style, trending on ArtStation, trending on CGSociety, Intricate, Vibrant colors, Soft Shading, Simplistic Features, Sharp Angles, Playful",
    "Vector art, Vivid colors, Clean lines, Sharp edges, Minimalist, Precise geometry, Simplistic, Smooth curves, Bold outlines, Crisp shapes, Flat colors, Illustration art piece, High contrast shadows, Technical illustration, Graphic design, Vector graphics, High contrast, Precision artwork, Linear compositions, Scalable artwork, Digital art",
    "(Extremely Detailed Oil Painting:1.2), glow effects, godrays, Hand drawn, render, 8k, octane render, cinema 4d, blender, dark, atmospheric 4k ultra detailed, cinematic sensual, Sharp focus, humorous illustration, big depth of field, Masterpiece, colors, 3d octane render, 4k, concept art, trending on artstation, hyperrealistic, Vivid colors, extremely detailed CG unity 8k wallpaper, trending on ArtStation, trending on CGSociety, Intricate, High Detail, dramatic, absurdes",
    "Indie game art,(", "), (Vector Art, Borderlands style, Arcane style, Cartoon style), Line art, Disctinct features, Hand drawn, Technical illustration, Graphic design, Vector graphics, High contrast, Precision artwork, Linear compositions, Scalable artwork, Digital art, cinematic sensual, Sharp focus, humorous illustration, big depth of field, Masterpiece, trending on artstation, Vivid colors, trending on ArtStation, trending on CGSociety, Intricate, Low Detail, dramatic",
    "Photorealistic, Hyperrealistic, Hyperdetailed, analog style, detailed skin, matte skin, soft lighting, subsurface scattering, realistic, heavy shadow, masterpiece, best quality, ultra realistic, 8k, golden ratio, Intricate, High Detail, film photography, soft focus",
    "(b&w, Monochromatic, Film Photography:1.3),  Photorealistic, Hyperrealistic, Hyperdetailed, film noir, analog style, soft lighting, subsurface scattering, realistic, heavy shadow, masterpiece, best quality, ultra realistic, 8k, golden ratio, Intricate, High Detail, film photography, soft focus",
    "Tiny cute isometric ", " in a cutaway box, soft smooth lighting, soft colors, 100mm lens, 3d blender render",
    "hologram of ", " floating in space, a vibrant digital illustration, dribbble, quantum wavetracing, black background, behance hd",
    "3d fluffy ", ", closeup cute and adorable, cute big circular reflective eyes, long fuzzy fur, Pixar render, unreal engine cinematic smooth, intricate detail, cinematic",
    "RAW candid cinema, 16mm, color graded portra 400 film, remarkable color, ultra realistic, textured skin, remarkable detailed pupils, realistic dull skin noise, visible skin detail, skin fuzz, dry skin, shot with cinematic camera",
    "long shot scenic professional photograph of ", ", perfect viewpoint, highly detailed, wide-angle lens, hyper realistic, with dramatic sky, polarizing filter, natural lighting, vivid colors, everything in sharp focus, HDR, UHD, 64K",
    "(Manga Style, Yusuke Murata, Satoshi Kon, Ken Sugimori, Hiromu Arakawa), Pencil drawing, (B&W:1.2), Low detail, sketch, concept art, Anime style, line art, webtoon, manhua, chalk, hand drawn, defined lines, simple shades, simplistic, manga page, minimalistic, High contrast, Precision artwork, Linear compositions, Scalable artwork, Digital art, High Contrast Shadows",
    "(Anime Scene, Toonshading, Satoshi Kon, Ken Sugimori, Hiromu Arakawa:1.2), (Anime Style, Manga Style:1.3), Low detail, sketch, concept art, line art, webtoon, manhua, hand drawn, defined lines, simple shades, minimalistic, High contrast, Linear compositions, Scalable artwork, Digital art, High Contrast Shadows, glow effects, humorous illustration, big depth of field, Masterpiece, colors, concept art, trending on artstation, Vivid colors, dramatic",
];

function escapeRegExp(string) {
    return string.replace(/[.*+\-?^${}()|[\]\\]/g, '\\$&');  // $& means the whole matched string
}

function cleanPrompt(prompt) {
    let cleanedPrompt = prompt;

    for (const style of broken_styles) {
        const escapedStyle = escapeRegExp(style);
        const regex = new RegExp(`\\s*${escapedStyle}\\s*,?`, 'g');
        cleanedPrompt = cleanedPrompt.replace(regex, '');
    }
    cleanedPrompt = cleanedPrompt.replace(/,\s*$/, '').trim();

    return cleanedPrompt;
}

function extractPrompt(imagePrompt) {
    let promptData = imagePrompt;
    for (const styleTags of Object.values(styles)) {
        const tags = styleTags.split(",").filter(tag => !tag.includes("{prompt}"));
        tags.forEach(tag => {
            const cleanedTag = escapeRegExp(tag.trim().split(":")[0]);
            // Removing tag from promptData if exists
            const regex = new RegExp(`\\s*${cleanedTag}\\s*,?`, 'g');
            promptData = promptData.replace(regex, '');
        });
    }
    return promptData.trim(); // return the cleaned data
}

var infoButton = document.getElementById('infoButton');
var downloadButton = document.getElementById('downloadButton');
var imageInfo = document.getElementById('sd-info');

infoButton.addEventListener('click', viewImageInfo);
downloadButton.addEventListener('click', function () {
    var url = '/' + downloadButton.getAttribute('data-link');
    window.open(url, '_blank');
    window.focus();
});
imageInfo.addEventListener('click', function () {
    toggleInfo('hide');
});

document.addEventListener('DOMContentLoaded', function () {
    var url = downloadButton.getAttribute('data-link');
    fetchImageInfo(url);
});
