<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\Section;
use App\Models\User;
use App\View\Components\Themes\Default\Contact as DefaultContactComponent;
use App\View\Components\Themes\Juno\Contact as JunoContactComponent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalendlyIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_resolves_calendly_url_from_profile_field(): void
    {
        $profile = Profile::first() ?? Profile::create([
            'user_id' => User::first()?->id ?? User::factory()->create()->id,
        ]);
        $profile->update([
            'calendly_url' => 'calendly.com/danial-demo/30min',
            'social'       => [],
        ]);

        $this->assertEquals('https://calendly.com/danial-demo/30min', $profile->fresh()->resolved_calendly_url);
    }

    /** @test */
    public function it_resolves_calendly_url_from_social_repeater_if_direct_field_is_empty(): void
    {
        $profile = Profile::first() ?? Profile::create([
            'user_id' => User::first()?->id ?? User::factory()->create()->id,
        ]);
        $profile->update([
            'calendly_url' => null,
            'social'       => [
                [
                    'social_network' => 'calendly',
                    'profile_link'   => 'https://calendly.com/social-link/15min',
                    'is_active'      => true,
                ],
            ],
        ]);

        $this->assertEquals('https://calendly.com/social-link/15min', $profile->fresh()->resolved_calendly_url);
    }

    /** @test */
    public function it_handles_null_or_empty_calendly_url_gracefully(): void
    {
        $profile = Profile::first() ?? Profile::create([
            'user_id' => User::first()?->id ?? User::factory()->create()->id,
        ]);
        $profile->update([
            'calendly_url' => null,
            'social'       => [],
        ]);

        $this->assertNull($profile->fresh()->resolved_calendly_url);
    }

    /** @test */
    public function it_can_update_and_clear_calendly_url(): void
    {
        $profile = Profile::first() ?? Profile::create([
            'user_id' => User::first()?->id ?? User::factory()->create()->id,
        ]);
        $profile->update([
            'calendly_url' => 'calendly.com/initial-link',
        ]);

        $this->assertEquals('https://calendly.com/initial-link', $profile->fresh()->resolved_calendly_url);

        // Update
        $profile->update(['calendly_url' => 'https://calendly.com/updated-link']);
        $this->assertEquals('https://calendly.com/updated-link', $profile->fresh()->resolved_calendly_url);

        // Clear
        $profile->update(['calendly_url' => null]);
        $this->assertNull($profile->fresh()->resolved_calendly_url);
    }

    /** @test */
    public function it_renders_calendly_meeting_card_on_default_theme_when_configured(): void
    {
        $profile = Profile::first() ?? Profile::create([
            'user_id' => User::first()?->id ?? User::factory()->create()->id,
        ]);
        $profile->update([
            'calendly_url' => 'calendly.com/danial-demo/meet',
        ]);

        $section = Section::firstWhere('slug', 'contact');
        if ($section) {
            $section->update([
                'is_active' => true,
                'content'   => array_merge($section->content ?? [], [
                    'email' => 'contact@example.com',
                ]),
            ]);
        } else {
            Section::create([
                'name'      => 'Contact',
                'slug'      => 'contact',
                'is_active' => true,
                'content'   => [
                    'email' => 'contact@example.com',
                ],
            ]);
        }

        $component = new DefaultContactComponent();
        $this->assertEquals('https://calendly.com/danial-demo/meet', $component->calendlyUrl);

        $rendered = $this->blade('<x-themes.default.contact />');
        $rendered->assertSee('Schedule a Meeting');
        $rendered->assertSee('Book a Meeting');
        $rendered->assertSee('https://calendly.com/danial-demo/meet');
    }

    /** @test */
    public function it_does_not_render_calendly_card_when_url_is_not_configured(): void
    {
        $profile = Profile::first() ?? Profile::create([
            'user_id' => User::first()?->id ?? User::factory()->create()->id,
        ]);
        $profile->update([
            'calendly_url' => null,
            'social'       => [],
        ]);

        $section = Section::firstWhere('slug', 'contact');
        if ($section) {
            $content = $section->content ?? [];
            unset($content['calendly_url']);
            $section->update([
                'is_active' => true,
                'content'   => $content,
            ]);
        }

        $component = new DefaultContactComponent();
        $this->assertNull($component->calendlyUrl);

        $rendered = $this->blade('<x-themes.default.contact />');
        $rendered->assertDontSee('Book a Meeting');
        $rendered->assertDontSee('Book time on Calendly');
    }

    /** @test */
    public function it_renders_calendly_meeting_card_on_juno_theme_when_configured(): void
    {
        $profile = Profile::first() ?? Profile::create([
            'user_id' => User::first()?->id ?? User::factory()->create()->id,
        ]);
        $profile->update([
            'calendly_url' => 'calendly.com/danial-demo/meet',
        ]);

        $section = Section::firstWhere('slug', 'contact');
        if ($section) {
            $section->update([
                'is_active' => true,
                'content'   => array_merge($section->content ?? [], [
                    'email' => 'contact@example.com',
                ]),
            ]);
        } else {
            Section::create([
                'name'      => 'Contact',
                'slug'      => 'contact',
                'is_active' => true,
                'content'   => [
                    'email' => 'contact@example.com',
                ],
            ]);
        }

        $component = new JunoContactComponent();
        $this->assertEquals('https://calendly.com/danial-demo/meet', $component->calendlyUrl);

        $rendered = $this->blade('<x-themes.juno.contact />');
        $rendered->assertSee('Schedule a Meeting');
        $rendered->assertSee('Book a Meeting');
        $rendered->assertSee('https://calendly.com/danial-demo/meet');
    }

    /** @test */
    public function it_renders_custom_calendly_icon_in_ui_icon_component(): void
    {
        $rendered = $this->blade('<x-ui.icon name="calendly" href="calendly.com/my-meet" />');
        $rendered->assertSee('https://calendly.com/my-meet');
        $rendered->assertSee('<svg', false);
    }

    /** @test */
    public function it_allows_admin_to_access_profile_edit_and_social_network_pages(): void
    {
        $user = User::first() ?? User::factory()->create();
        $profile = Profile::firstWhere('user_id', $user->id) ?? Profile::create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get(route('filament.admin.resources.profiles.edit', ['record' => $profile->id]));
        $response->assertStatus(200);
        $response->assertSee('Calendly Meeting Link');

        $responseSocial = $this->actingAs($user)->get(route('filament.admin.resources.profiles.edit-social-network', ['record' => $profile->id]));
        $responseSocial->assertStatus(200);
        $responseSocial->assertSee('Calendly Meeting Link');
    }
}
