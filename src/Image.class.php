<?php
class Image {
  private $imageType;
	private $imageResource = null;

	function __construct($filename) {
		$this->load($filename);
	}

	public function load($filename)
	{
		$image_info = @getimagesize($filename);
    	$this->imageType = $image_info[2];

    	switch ($this->imageType) {
    		case IMAGETYPE_JPEG:
    			$this->imageResource = @imagecreatefromjpeg($filename);
    			break;
    		
    		case IMAGETYPE_GIF:
    			$this->imageResource = @imagecreatefromgif($filename);
    			break;

    		case IMAGETYPE_PNG:
    			$this->imageResource = @imagecreatefrompng($filename);
    			break;
    	}
	}

	public function save($filename, $imageType = "jpeg")
	{
		switch ($imageType) {
			case "jpeg":
				imageinterlace($this->imageResource, 1);
				imagejpeg($this->imageResource, $filename);
				break;

			case "png":
				imagepng($this->imageResource, $filename);
				break;

			case "gif":
				imagegif($this->image, $filename);
				break;
		}
	}

	public function getWidth()
	{
		return imagesx($this->imageResource);
	}

	public function getHeight()
	{
		return imagesy($this->imageResource);
	}

	public function scale($scale)
	{
		$width = $this->getWidth() * $scale / 100;
    	$height = $this->getHeight() * $scale / 100;

    	$this->resize($width, $height);
	}

	public function scaleToWidth($width)
	{
		$scale = $width / $this->getWidth();
      	$height = $this->getHeight() * $scale;

		$this->resize($width, $height);
	}

	public function scaleToHeight($height)
	{
		$scale = $height / $this->getHeight();
    	$width = $this->getWidth() * $scale;

    	$this->resize($width, $height);
	}

	public function resize($width, $height)
	{
		$resizedImageResource = @imagecreatetruecolor($width, $height);

    	@imagecopyresampled(
    		$resizedImageResource, 
    		$this->imageResource, 
    		0, 0, 
    		0, 0, 
    		$width, 
    		$height, 
    		$this->getWidth(),
    		$this->getHeight()
    	);

    	$this->imageResource = $resizedImageResource;
	}
}
?>
