<template>
    <td
        v-bind="$attrs"
        class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200"
    >
        <slot />
    </td>
</template>
