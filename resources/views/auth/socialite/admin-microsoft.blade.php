<x-filament::button :href="route('admin.socialite.redirect', ['provider' => 'microsoft'])" tag="a" color="gray" class="justify-center w-full">
    <div class="flex items-center justify-center gap-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-2" width="16" height="16" viewBox="0 0 1024 1024"
            fill="none">
            <path d="M44.522 44.5217H489.739V489.739H44.522V44.5217Z" fill="#F35325" />
            <path d="M534.261 44.5217H979.478V489.739H534.261V44.5217Z" fill="#81BC06" />
            <path d="M44.522 534.261H489.739V979.478H44.522V534.261Z" fill="#05A6F0" />
            <path d="M534.261 534.261H979.478V979.478H534.261V534.261Z" fill="#FFBA08" />
        </svg>
        Sign in with Microsoft
    </div>
</x-filament::button>
