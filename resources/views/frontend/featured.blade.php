<div class="expanded">
    <h2>Featured episode</h2>
</div>
<div class="feature flex">
    <div class="image third featured">
        <img src="/coverart/{{ $featured->imageFilename }}.jpg" alt="Cover art for {{ $featured->title }}" />
    </div>
    <div class="episodeData third">
        <div class="episodeInfo featured">Title:</div>
        <div class="title highlight featured">{{ $featured->title }}</div>
        <div class="episodeInfo featured">Style / Genre:</div>
        <div class="style genre featured">{{ $featured->style }} / {{ $featured->genre }}</div>
        @if ($featured->twitchSafe == true)
            <div class="featured"><span class="tag twitch">Twitch-safe</span></div>
        @endif
    </div>
    <div class="buttons third">
        @if ($featured->twitchId || $featured->youtubeId || $featured->redditId)
            @if ($featured->twitchId && !$featured->twitchTooOld)
                <div class="button right twitch"><a href="https://twitch.tv/videos/{{ $featured->twitchId }}"><i
                            class="fa-brands fa-twitch"></i> Twitch</a></div>
            @endif
            @if ($featured->youtubeId)
                <x-crate-button link="https://youtu.be/{{ $featured->youtubeId }}" icon="fa-brands fa-youtube" text="YouTube" color="youtube"/>
            @endif
        @endif
        @if ($featured->mp3Filename)
            <x-crate-button link="{{ asset('mp3/' . rawurlencode($featured->mp3Filename) . '.mp3') }}" icon="fa-solid fa-podcast" text="MP3" color="blue"/>
        @endif
    </div>
</div>
