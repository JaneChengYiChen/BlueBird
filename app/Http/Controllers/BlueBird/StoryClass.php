<?php

namespace App\Http\Controllers\BlueBird;

use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder;
use LINE\LINEBot\MessageBuilder\FlexMessageBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\BubbleContainerBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ImageComponentBuilder;
use LINE\LINEBot\Constant\Flex\ComponentImageSize;
use LINE\LINEBot\Constant\Flex\ComponentLayout;
use LINE\LINEBot\Constant\Flex\ComponentImageAspectRatio;
use LINE\LINEBot\Constant\Flex\ComponentImageAspectMode;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\Constant\Flex\ComponentMargin;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\CarouselContainerBuilder;

class StoryClass
{
    protected static $storiesContents = [
        [
            'url'=>'https://i.imgur.com/xaDo92Q.jpg',
            'text'=>"該做的事，就是走該走的路"
        ],
        [
            'url'=>'https://i.imgur.com/fGB8fJy.jpg',
            'text'=>"要總是專注思考而列出該做的事，身軀要實踐，度過走該走之路的生活"
        ],
        [
            'url'=>'https://i.imgur.com/MKdFOVY.jpg',
            'text'=>"如果普通地思考，就只能想到普通的事物"
        ],
        [
            'url'=>'https://i.imgur.com/MBwAl8d.jpg',
            'text'=>"提升一個層次思考的人，才會想到與眾不同的事物"
        ],
    ];

    public function main()
    {
        $BubblesArray=[];
        foreach (self::$storiesContents as $value) {
            $url = $value['url'];
            $text = $value['text'];

            $BubblesArray[]= $this->onePage()
            ->setHero($this->imageBuilder($url))
            ->setFooter($this->descriptionBuilder($text));
        }

        return $this->multiplePage($BubblesArray);
    }

    public function multiplePage($BubblesArray)
    {
        return FlexMessageBuilder::builder()
        ->setAltText('Enjoy!')
        ->setContents(
            CarouselContainerBuilder::builder()
            ->setContents($BubblesArray)
        );
    }

    public function onePage()
    {
        return BubbleContainerBuilder::builder();
    }

    private function imageBuilder($url)
    {
        return ImageComponentBuilder::builder()
                ->setUrl($url)
                ->setSize(ComponentImageSize::FULL)
                ->setAspectMode(ComponentImageAspectMode::FIT);
    }

    private function descriptionBuilder($text)
    {
        return BoxComponentBuilder::builder()
                ->setLayout(ComponentLayout::HORIZONTAL)
                ->setContents(
                    array(
                        TextComponentBuilder::builder()
                            ->setText($text)
                            ->setColor('#aaaaaa')
                            ->setSize('sm')
                            ->setMargin(ComponentMargin::XS)
                            ->setFlex(5)
                            ->setAlign('center')
                            ->setWrap(true)
                    )
                );
    }
}
