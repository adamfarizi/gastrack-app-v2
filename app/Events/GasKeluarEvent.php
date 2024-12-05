<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GasKeluarEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $nama_perusahaan;
    public $jenis_rumus;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($nama_perusahaan, $jenis_rumus)
    {
        $this->nama_perusahaan = $nama_perusahaan;
        $this->jenis_rumus = $jenis_rumus;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('GasKeluar-channel');
    }
}
