<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mail>
 */
class MailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'    => 'Danial Folio Mail',
            'phone'   => '999999-9999',
            'email'   => 'danial.qamar.dev@gmail.com',
            'subject' => 'Welcome to DanialFolio 🎉',
            'body'    => 'We\'re excited to have you onboard! 🎉
                                <br/>
                                This is a test email from DanialFolio, making sure everything is working smoothly.
                                <p></p>
                                ✅ What\'s new?
                                <p></p>
                                Your personal blog is ready! 📝 <br/>
                                New Mail View Layout. ✨<br/>
                                Dark mode is now the default. 🌙<br/>
                                Improved performance and smoother experience. ⚡ <br/>
                                Customizable background images across the app! 🌍<br/>
                                Start exploring and let us know what you think! If you have any questions, we\'re here to help.
                                <p></p>
                                Happy exploring! 🚀
                                <p></p>
                                — Marcos Coelho',
            'is_read'      => false,
            'is_important' => false,
            'created_at'   => now(),
        ];
    }
}
