<?php
require_once "c4vxl_YoutubeChannel_module.php";

$channelId = 'UCBR8-60-B28hp2BmDPdntcQ';
$channel = new YoutubeChannel($channelId);

echo "Channel Name: " . $channel->channel_name . "\n";
echo "Created At: " . $channel->created_at . "\n";
echo "Total Videos: " . $channel->videoCount . "\n";

$videos = $channel->getVideos();

foreach ($videos as $video) {
    echo "Title: " . $video['title'] . "\n";
    echo $video['embed'] . "\n";
    echo "Published: " . $video['published'] . "\n";
    echo "Description: " . $video['description'] . "\n";
    echo "URL: " . $video['url'] . "\n";
    echo "Thumbnail: " . $video['thumbnail'] . "\n";
    echo "----------------------------------------\n";
}