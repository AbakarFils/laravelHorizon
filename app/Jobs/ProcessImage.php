<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Intervention\Image\ImageManager;

class ProcessImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var string|string
     */
    private $image_path;
    /**
     * @var string|string
     */
    private $suffix;
    /**
     * @var int|int
     */
    private $width;
    /**
     * @var int|int
     */
    private $height;

    public function tags(){
        return ['resize',"resize:{$this->suffix}","resize:{$this->suffix}:{$this->image_path}"];
    }

    /**
     * Create a new job instance.
     *
     * @param string $image_path
     * @param string $suffix
     * @param int $width
     * @param int $height
     */
    public function __construct(string $image_path,string $suffix, int  $width, int $height=null)
    {
        //
        $this->image_path = $image_path;
        $this->suffix = $suffix;
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        sleep(2);
        $extension= pathinfo($this->image_path,PATHINFO_EXTENSION);
        $basename= pathinfo($this->image_path,PATHINFO_BASENAME);
        $manager =new ImageManager(['driver'=>'gd']);
        $image =$manager->make($this->image_path);
        if($this->height)
        {
            $image= $image->fit($this->width,$this->height);
        }else
        {
            $image =$image->resize($this->width,null);
        }
        $image->save(
          storage_path('dist/'.preg_replace("/(\.$extension)$/","{$this->suffix}.jpg",$basename))
        );
    }
}
