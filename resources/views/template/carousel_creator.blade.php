<?php
    $top = -50;
    $gap = 30;
    $upCount = 3;
    $isDown = 1;
?>
<div class="swiper-container">
  <div class="swiper-wrapper">
      @for($i = 0 ; $i < count($playedcreators) ; $i++)
      <?php
        $playedcreator = $playedcreators[$i];
        $socialChannel_1 = $playedcreator->channel_1;
        $socialChannel_2 = $playedcreator->channel_2;

        if($socialChannel_1 === "youtube")
        {
            $socialChannel_1 = asset('/img/icons/svg/ic-main-creator-social-youtube.svg');
        }
        else if($socialChannel_1 === "tiktok")
        {
            $socialChannel_1 = asset('/img/icons/svg/ic-main-creator-social-tiktok.svg');
        }
        else if($socialChannel_1 === "instagram")
        {
            $socialChannel_1 = asset('/img/icons/svg/ic-main-creator-social-insta.svg');
        }
        else if($socialChannel_1 === "twitch")
        {
            $socialChannel_1 = asset('/img/icons/svg/ic-main-creator-social-twitch.svg');
        }

        if($socialChannel_2 === "youtube")
        {
            $socialChannel_2 = asset('/img/icons/svg/ic-main-creator-social-youtube.svg');
        }
        else if($socialChannel_2 === "tiktok")
        {
            $socialChannel_2 = asset('/img/icons/svg/ic-main-creator-social-tiktok.svg');
        }
        else if($socialChannel_2 === "instagram")
        {
            $socialChannel_2 = asset('/img/icons/svg/ic-main-creator-social-insta.svg');
        }
        else if($socialChannel_2 === "twitch")
        {
            $socialChannel_2 = asset('/img/icons/svg/ic-main-creator-social-twitch.svg');
        }
        
      ?>
        <div class="swiper-slide">
            <!--<div class="creator_slide_container" style="position:absolute; width:190px; height:190px; margin-top:{{$top}}px">-->
            <div class="creator_slide_container" style="margin-top:{{$top}}px">
                <a href="{{url('/projects/'.$playedcreator->project_alias)}}">
                    <img src="{{$playedcreator->img_url}}" style="width:100%; border-radius: 20px; background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.3)); box-shadow: 10px 10px 20px 0 rgba(0, 0, 0, 0.2);"/>
                    <div class="thumb-black-mask">
                    </div>
                    <div class="creator_slide_name" style="position:absolute; bottom:12px; left: 12px; font-size: 12px; color: white;">
                        @if($socialChannel_1)
                            <img src="{{$socialChannel_1}}">
                        @endif
                        @if($socialChannel_2)
                            <img src="{{$socialChannel_2}}">
                        @endif
                        {{$playedcreator->name}}
                    </div>
                    <div class="creator_slide_name" style="position:absolute; bottom:12px; right: 12px; font-size: 12px; color: white;">
                        {{$playedcreator->subscription}}
                    </div>
                </a>
            </div>
        </div>
        <?php
        
        if($i > 0 && $i % $upCount === 0)
        {
            if($isDown === 1)
            {
                $isDown = -1;
            }
            else
            {
                $isDown = 1;
            }
        }
        $top = $top + ($gap * $isDown);
        //$top+=$gap;
        ?>
      @endfor
  </div>
</div>
