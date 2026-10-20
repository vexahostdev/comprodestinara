@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#1F2B45] dark:focus:border-[#8FA8D0] focus:ring-[#1F2B45] dark:focus:ring-[#8FA8D0] rounded-xl shadow-sm']) }}>
