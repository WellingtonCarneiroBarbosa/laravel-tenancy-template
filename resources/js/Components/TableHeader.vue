<template>
    <th
        v-bind="$attrs"
        scope="col"
        class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase"
    >
        <slot />
    </th>
</template>
