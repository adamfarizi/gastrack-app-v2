<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Chart2Event implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $nama_perusahaan;
    public $jumlah_tagihan;
    public $bulan;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($nama_perusahaan, $jumlah_tagihan, $bulan)
    {
        $this->nama_perusahaan = $nama_perusahaan;
        $this->jumlah_tagihan = $jumlah_tagihan;
        $this->bulan = $bulan;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('Chart2-channel');
    }
}
