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
                    {!! html_entity_decode($messages->message) !!}
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
        <x-crate-button link="/gallery" icon="fa-solid fa-image" text="Gallery" color="orange"/>
        <x-crate-button link="https://twitch.tv/niddelicious" icon="fa-brands fa-twitch" text="Twitch" color="twitch"/>
        <x-crate-button link="https://www.youtube.com/@niddelicious" icon="fa-brands fa-youtube" text="YouTube" color="youtube"/>
        <x-crate-button link="https://instagram.com/niddelicious" icon="fa-brands fa-instagram" text="Instagram" color="instagram"/>
        <x-crate-button link="https://discord.gg/jXxtveja5F" icon="fa-brands fa-discord" text="Discord" color="discord"/>
        <x-crate-button link="https://niddelicious.myspreadshop.se/" icon="fas fa-tshirt" text="Merch EU" color="green"/>
        <x-crate-button link="https://niddelicious.myspreadshop.com/" icon="fas fa-tshirt" text="Merch US" color="green"/>
    </div>
</div>
