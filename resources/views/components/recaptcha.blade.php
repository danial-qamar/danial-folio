@if (!empty($siteKey))
<div class="flex justify-center mb-4" wire:ignore>
    <div class="g-recaptcha" data-sitekey="{{ $siteKey }}" data-callback="onRecaptchaSuccess"></div>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    function onRecaptchaSuccess(token) {
        Livewire.dispatch('recaptcha-success', { token: token });
    }

    function initRecaptcha() {
        if (typeof grecaptcha !== 'undefined') {
            let el = document.querySelector('.g-recaptcha');
            if (el) {
                grecaptcha.render(el);
            }
        } else {
            setTimeout(initRecaptcha, 500);
        }
    }

    document.addEventListener('livewire:init', () => {
        initRecaptcha();
    });

    document.addEventListener('livewire:navigated', () => {
        if (typeof grecaptcha !== 'undefined') {
            grecaptcha.reset();
        }
    });
</script>
@endif
