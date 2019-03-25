<div class="sm2-bar-ui compact full-width" id="mySound">
    <div class="bd sm2-main-controls">
        <div class="sm2-inline-element sm2-button-element">
            <div class="sm2-button-bd">
                <a href="#play" class="sm2-inline-button sm2-icon-play-pause">Play / pause</a>
            </div>
        </div>
        <div class="sm2-inline-element sm2-inline-status">
            <div class="sm2-playlist">
                <div class="sm2-playlist-target">
                    <ul class="sm2-playlist-bd">
                        <li></li>
                    </ul>
                </div>
            </div>
            <div class="sm2-progress">
                <div class="sm2-row">
                    <div class="sm2-inline-time">0:00</div>
                    <div class="sm2-progress-bd">
                        <div class="sm2-progress-track" style="background: url('waveform_example.png'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
                            <div class="sm2-progress-bar"></div>
                            <div class="sm2-progress-ball">
                            </div>
                        </div>
                    </div>
                    <div class="sm2-inline-duration">0:00</div>
                </div>
            </div>
        </div>
        <div class="sm2-inline-element sm2-button-element sm2-volume">
            <div class="sm2-button-bd">
                <span class="sm2-inline-button sm2-volume-control volume-shade"></span>
                <a href="#volume" class="sm2-inline-button sm2-volume-control">volume</a>
            </div>
        </div>
    </div>
    <div class="bd sm2-playlist-drawer sm2-element" style="background-color: rgb(205, 158, 31);">
        <div class="sm2-inline-texture">
            <div class="sm2-box-shadow"></div>
        </div>
        <!-- playlist content is mirrored here -->
        <div class="sm2-playlist-wrapper">
            <ul class="sm2-playlist-bd">
                <!-- Enter all sound clips as list items, per the example code below -->
                <li>
                    <a href="{{ '/test.mp3' }}">Foobar - I got the power</a>
                </li>
            </ul>
        </div>
    </div>
</div>