# YouTube Channel Data Retrieval PHP Module

This PHP module allows you to retrieve data from a YouTube channel using only the channel ID, without the need for an API key. It provides information about the channel, its videos, and their details.

---

## Installation

1. Clone or download this repository to your project directory.
2. Include the `c4vxl_YoutubeChannel_module.php` file in your PHP project.

## Usage

1. Create an instance of the `c4vxl_YoutubeChannel_module` class by passing the channel ID as a parameter to the constructor.

```php
require_once('c4vxl_YoutubeChannel_module.php');

$channelId = 'YOUR_CHANNEL_ID';
$channel = new YoutubeChannel($channelId);
```

2. Retrieve general channel information:
```php
$channelName = $channel->channel_name;
$createdAt = $channel->created_at;
$videoCount = $channel->videoCount;
```

3. Get an array of all videos on the channel:
```php
$videos = $channel->getVideos();
```

4. Retrieve details of a specific video using its index:
```php
$index = 0; // Index of the video in the videos array
$video = $channel->getVideo($index);
```

## Example

To show the functionality of this tool, this example code will list all videos of the youtube channel "YouTube":
```php
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
```
---
## Developer
This Project was Developed by [c4vxl](https://c4vxl.de)
