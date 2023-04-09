<div class="flex">
    <div class="title expanded">
        <h1>
            <img class="script-logo" src="{{ asset('images/niddelicious-script-cropped-blackish.png') }}"
                alt="Script logo for niddelicious and nidde.nu" />
        </h1>
    </div>
    <div class="portrait third">
        @if ($messages)
            <div class="speechBubble">
                @if ($messages->header)
                    <h3> {{ $messages->header }}</h3>
                @endif
                <p>
                    {{ $messages->message }}
                </p>
            </div>
        @endif
        <img src="{{ asset('images/profile-pic.jpg') }}" alt="Profile picture" class="profilePic" />
    </div>
    <div class="info third">
        <p>
            I go by <span class="highlight">niddelicious</span> and I like to play music.
            Sadly, I don't mean with an instrument, but as a DJ.
            I dabble in many types of music, but electronic is the primary sort.
            Within the electronic dance space I enjoy a wide range of sounds,
            from slow and relaxing Chillout, to funky and groovy House,
            deep and melodic Techno, mind-bending Psychedelic Trance, and high energy Hardstyle.
        </p>
        <p>
            Feel free to join me live on Twitch. Or have a look in the archive for a style that suits you.
        </p>
        <p>
            <span class="smallPrint">On-screen chat and commands for lights and effects are only available on
                Twitch</span>
        </p>
    </div>
    <div class="siteButtons third">

        <h3>Links:</h3>
        <div class="button twitch"><a href="https://twitch.tv/niddelicious"><i class="fa-brands fa-twitch"></i>
                Twitch</a></div>
        <div class="button youtube"><a href="https://www.youtube.com/@niddelicious"><i class="fa-brands fa-youtube"></i>
                YouTube</a></div>
        <div class="button instagram"><a href="https://instagram.com/niddelicious"><i
                    class="fa-brands fa-instagram"></i> Instagram</a></div>
        <div class="button reddit"><a href="https://www.reddit.com/u/niddelicious"><i class="fa-brands fa-reddit"></i>
                Reddit</a></div>
        <div class="button"><a href="https://niddelicious.myspreadshop.se/"><i class="fas fa-tshirt"></i>
                Merch EU</a></div>
        <div class="button"><a href="https://niddelicious.myspreadshop.com/"><i class="fas fa-tshirt"></i>
                Merch NA</a></div>

    </div>
</div>
