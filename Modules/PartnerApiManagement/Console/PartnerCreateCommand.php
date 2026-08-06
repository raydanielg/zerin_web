<?php

namespace Modules\PartnerApiManagement\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\PartnerApiManagement\Entities\Partner;
use Modules\UserManagement\Service\Interfaces\CustomerServiceInterface;

class PartnerCreateCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'partner:create
        {name : Partner/business name}
        {email? : Partner contact email}
        {--phone= : Contact phone number used for the underlying customer account}
        {--webhook= : URL that will receive delivery status webhooks}';

    /**
     * @var string
     */
    protected $description = 'Create a new delivery API partner and issue its API key/secret pair.';

    public function handle(CustomerServiceInterface $customerService)
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $phone = $this->option('phone') ?: '00000000000' . random_int(0, 999);
        $webhook = $this->option('webhook');

        $apiKey = 'pk_' . Str::random(24);
        $apiSecret = Str::random(40);
        $webhookSecret = Str::random(40);

        DB::beginTransaction();
        try {
            [$firstName, $lastName] = $this->splitName($name);

            $customer = $customerService->createExternalCustomer([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $phone,
            ]);

            $partner = Partner::create([
                'name' => $name,
                'email' => $email,
                'api_key' => $apiKey,
                'api_secret' => Hash::make($apiSecret),
                'customer_id' => $customer->id,
                'webhook_url' => $webhook,
                'webhook_secret' => $webhookSecret,
                'is_active' => true,
            ]);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->error('Failed to create partner: ' . $exception->getMessage());
            return self::FAILURE;
        }

        $this->info('Partner created successfully.');
        $this->table(['Field', 'Value'], [
            ['Partner ID', $partner->id],
            ['API Key', $apiKey],
            ['API Secret', $apiSecret],
            ['Webhook Secret', $webhookSecret],
        ]);
        $this->warn('Save the API secret and webhook secret now, they will not be shown again.');

        return self::SUCCESS;
    }

    private function splitName(string $name): array
    {
        $parts = preg_split('/\s+/', trim($name), 2);
        return [$parts[0], $parts[1] ?? $parts[0]];
    }
}
