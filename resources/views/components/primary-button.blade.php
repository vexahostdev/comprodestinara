<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#1F2B45] dark:bg-[#8FA8D0] border border-transparent rounded-2xl font-semibold text-xs text-white dark:text-[#0E1422] uppercase tracking-widest hover:bg-[#2E3D5C] dark:hover:bg-[#AFC0D8] focus:bg-[#2E3D5C] dark:focus:bg-[#AFC0D8] active:bg-[#16203A] dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-[#1F2B45] focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
