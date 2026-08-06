<div class="relative inline-flex items-center p-0.5 bg-gray-200/50 dark:bg-gray-900/60 border border-gray-300/40 dark:border-gray-800/40 backdrop-blur-md rounded-full w-[112px] h-8 select-none mx-2" dir="ltr">
    <!-- Active highlight background slider -->
    <div class="absolute top-0.5 bottom-0.5 left-0.5 w-[54px] bg-white dark:bg-gray-800 rounded-full shadow-md border border-gray-200/30 dark:border-gray-700/30 transition-transform duration-300 ease-in-out"
         style="transform: translateX({{ app()->getLocale() === 'id' ? '54px' : '0px' }});"></div>

    <!-- AR Option -->
    <a href="{{ route('switch-language', 'ar') }}" 
       class="relative z-10 flex items-center justify-center gap-1.5 w-[54px] h-full text-[10px] font-extrabold tracking-wider uppercase transition duration-300 {{ app()->getLocale() === 'ar' ? 'text-gray-900 dark:text-white' : 'text-gray-400/80 dark:text-gray-500/80 hover:text-gray-600 dark:hover:text-gray-300' }}"
       title="العربية">
        <!-- Saudi Flag (CSS Circular wrapper) -->
        <div class="w-3.5 h-3.5 rounded-full overflow-hidden shadow-sm flex-shrink-0 ring-1 ring-black/5 transition duration-300 {{ app()->getLocale() === 'ar' ? 'scale-105' : 'scale-90 opacity-70' }}">
            <svg class="w-full h-full" viewBox="0 0 30 20">
                <rect width="30" height="20" fill="#006C35"/>
                <!-- Simplified sword in white -->
                <path d="M6 14h18v1H6zm18 0l-3-2v4z" fill="#FFF"/>
                <!-- Simplified script representation in white -->
                <path d="M10 6h10v2H10z" fill="#FFF"/>
            </svg>
        </div>
        <span>AR</span>
    </a>

    <!-- ID Option -->
    <a href="{{ route('switch-language', 'id') }}" 
       class="relative z-10 flex items-center justify-center gap-1.5 w-[54px] h-full text-[10px] font-extrabold tracking-wider uppercase transition duration-300 {{ app()->getLocale() === 'id' ? 'text-gray-900 dark:text-white' : 'text-gray-400/80 dark:text-gray-500/80 hover:text-gray-600 dark:hover:text-gray-300' }}"
       title="Indonesia">
        <!-- Indonesia Flag (CSS Circular wrapper) -->
        <div class="w-3.5 h-3.5 rounded-full overflow-hidden shadow-sm flex-shrink-0 ring-1 ring-black/5 transition duration-300 {{ app()->getLocale() === 'id' ? 'scale-105' : 'scale-90 opacity-70' }}">
            <svg class="w-full h-full" viewBox="0 0 3 2">
                <rect width="3" height="1" fill="#e70012"/>
                <rect width="3" height="1" y="1" fill="#ffffff"/>
            </svg>
        </div>
        <span>ID</span>
    </a>
</div>
