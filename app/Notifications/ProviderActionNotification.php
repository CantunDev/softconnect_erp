    <?php

    namespace App\Notifications;

    use App\Models\Sfrt\Provider;
    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Notifications\Messages\MailMessage;
    use Illuminate\Notifications\Notification;

    class ProviderActionNotification extends Notification
    {
        use Queueable;

        public $provider;
        public $action;
        /**
         * Create a new notification instance.
         */
        public function __construct(Provider $provider, string $action)
        {
            $this->provider = $provider;
            $this->action = $action;
        }

        /**
         * Get the notification's delivery channels.
         *
         * @return array<int, string>
         */
        public function via(object $notifiable): array
        {
            return ['mail', 'database'];
        }

        /**
         * Get the mail representation of the notification.
         */
        public function toMail(object $notifiable): MailMessage
        {
            $title = $this->getTitle();
            $body = $this->getMessage();

            return (new MailMessage)
                ->subject($title)
                ->line($body)
                ->action('Ver proveedor', url('/corazon-contento/sagrado-comal/proveedores/' . $this->provider->idproveedor))
                ->line('Thank you for using our application!');
        }

        public function toDatabase(object $notifiable): array
        {
           \Log::info('Storing notification to database', [
        'notifiable_id' => $notifiable->id,
        'provider_id' => $this->provider->id,
        'action' => $this->action
    ]);
            return [
                'titulo' => $this->getTitle(),
                'mensaje' => $this->getMessage(),
                'url' => url('/proveedores/' . $this->provider->idproveedor),
            ];
        }

        /**
         * Get the array representation of the notification.
         *
         * @return array<string, mixed>
         */
        public function toArray(object $notifiable): array
        {
            return [
                'titulo' => $this->getTitle(),
                'mensaje' => $this->getMessage(),
                'url' => url('/proveedores/' . $this->provider->idproveedor),
            ];
        }

        protected function getTitle()
        {
            return match ($this->action) {
                'created' => 'Proveedor creado',
                'updated' => 'Proveedor actualizado',
                'deleted' => 'Proveedor eliminado',
                default => 'Acción desconocida con proveedor',
            };
        }

        protected function getMessage()
        {
            return match ($this->action) {
                'created' => "Se creó el proveedor: {$this->provider->nombre}",
                'updated' => "Se actualizó el proveedor: {$this->provider->nombre}",
                'deleted' => "Se eliminó el proveedor: {$this->provider->nombre}",
                default => 'Hubo una acción con proveedor.',
            };
        }
    }
