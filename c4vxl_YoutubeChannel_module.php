<?php
class YoutubeChannel {
    /**
     * Get the channel id
     * @return string Returns the id of the channel
     */
    public string $channel_id;

    /**
     * Get the dataURL of the xml file
     * @return string Returns the link to the xml data file
     */
    public string $dataURL;

    /**
     * Video count
     * @return int Returns the counted videos on the channel
     */
    public int $videoCount;

    /**
     * Channel Name
     * @return string Returns the channel name
     */
    public string $channel_name;
    
    /**
     * Created At
     * @return string Returns the date and time the channel has been created
     */
    public string $created_at;

    public $xml;

    /**
     * Constructor method
     * @param string $channel_id Pass the id of the channel
     */
    public function __construct(string $channel_id) {
        // handle channelId variable
        $this->channel_id = $channel_id;

        // get data url
        $this->dataURL = "https://www.youtube.com/feeds/videos.xml?channel_id=" . $channel_id;

        // get xml from dataurl
        $this->xml = simplexml_load_file($this->dataURL);

        // count entrys in xml file
        $this->videoCount = count($this->xml->entry);

        // get the channel name
        $this->channel_name = $this->xml->author->name;

        // get the date when the channel has been created
        $this->created_at = $this->xml->published;
    }

    /**
     * get all videos of the channel
     * @return array Returns an array with all videos
     */
    public function getVideos() {
        // create an empty array
        $array = array();
        // loop throught all videos
        for($i=0;$i<$this->videoCount;$i++) {
            // get xml entry
            $video = $this->xml->entry[$i];

            // get data from video
            $published = (string) $video->published;
            $updated = (string) $video->updated;
            $thumbnail = (string) $video->children('media', true)->group->thumbnail[0]->attributes()['url'];
            $description = (string) $video->children('media', true)->group->description;
            $title = (string) $video->title;
            $videoId = substr($video->id, strrpos($video->id, ':') + 1);
            $url = "https://www.youtube.com/watch?v=" . $videoId;
            $embedURL = "https://www.youtube.com/embed/" . $videoId;
            $accountName = (string) $video->author->name;
            $embed = '<iframe src="' . $embedURL . '" title="' . $title . '" allowfullscreen></iframe>';

            // make an array out of the video data
            $videoData = [
                "published" => $published,
                "updated" => $updated,
                "thumbnail" => $thumbnail,
                "description" => $description,
                "title" => $title,
                "videoId" => $videoId,
                "url" => $url,
                "embedURL" => $embedURL,
                "accountName" => $accountName,
                "embed" => $embed
            ];

            // push video data into array
            array_push($array, $videoData);
        }

        // return array
        return $array;
    }

    /**
     * Get the data of an video
     * @param int $index Pass the index of the video
     * @return array|null
     */
    public function getVideo(int $index): array {
        $videos = $this->getVideos();

        // return null if video does not exist
        if (!isset($videos[$index])) {
            return [
                "published" => null,
                "updated" => null,
                "thumbnail" => null,
                "description" => null,
                "title" => null,
                "videoId" => null,
                "url" => null,
                "embedURL" => null,
                "accountName" => null,
                "embed" => null
            ];
        }

        // get videoData
        $videoData = $videos[$index];

        // return array
        return $videoData;
    }

    /**
     * Get the first video on the channel
     * @return array
    */
    public function getFirstVideo(): array {
        return $this->getVideo($this->videoCount - 1);
    }

    /**
     * Get the last uploaded video on the channel
     * @return array
    */
    public function getLastVideo(): array {
        return $this->getVideo(0);
    }
}

$channelId = 'UCBR8-60-B28hp2BmDPdntcQ';
$channel = new YoutubeChannel($channelId);

$videos = $channel->getVideos();

foreach ($videos as $video) {
    echo "<br><br><br>----------------------------------------<br>";
    echo "<b>Title:</b> " . $video['title'] . "<br>";
    echo $video['embed'] . "<br>";
    echo "<b>Published:</b> " . $video['published'] . "<br>";
    echo "<b>Description:</b> " . $video['description'] . "<br>";
    echo "<b>URL:</b> " . $video['url'] . "<br>";
    echo "<b>Thumbnail:</b> " . $video['thumbnail'] . "<br>";
    echo "----------------------------------------<br><br><br>";
}