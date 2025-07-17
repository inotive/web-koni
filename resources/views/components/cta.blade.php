<section class="bg-eerie-black text-white relative">
    <img class="absolute top-[-5%] right-0 w-[20rem] lg:w-fit"
        src="{{ asset('landing-assets/img/illustration/decoration/right.svg') }}" alt="decoration-right">
    <img class="absolute bottom-[-4%] left-0 w-[20rem] lg:w-fit"
        src="{{ asset('landing-assets/img/illustration/decoration/left.svg') }}" alt="decoration-left">

    <div class="container mx-auto px-4 lg:px-10">
        <div class="flex flex-col items-start lg:items-center lg:text-center gap-8 py-24">
            <div class="text-2xl lg:text-3xl lg:text-[42px] lg:leading-snug font-bold">
                <div class="text-Orange-Primary">{{ __('menu.cta.question') }}</div>
                <div>{{ __('menu.cta.ask') }}</div>
            </div>
            <div class="text-base lg:text-xl">
                {{ __('menu.cta.description') }}
            </div>
            <a href="{{ route('contact.index') }}"
                class="h-12 w-full lg:w-48 bg-Orange-Primary text-white border border-Orange-Primary rounded-xl font-bold flex justify-center items-center gap-2 lg:mx-auto">
                <div class="text-sm font-bold">{{ __('button.contact_us') }}</div>
            </a>
        </div>
    </div>
</section>
