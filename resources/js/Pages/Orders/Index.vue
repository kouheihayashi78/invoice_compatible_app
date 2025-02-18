<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link,useForm } from '@inertiajs/vue3';
import DangerButton from '@/Components/DangerButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, watchEffect } from 'vue';

const props = defineProps({
    orders: {type:Object},
    search_str: String,
    success: String,
    successDel: String
});

const successMessage = ref(null)
const successDelMessage = ref(null)

watchEffect(() => {
    if (props.success) {
        successMessage.value = props.success;
        setTimeout(() => {
            successMessage.value = null;
        }, 3000);
    }
    if (props.successDel) {
        successDelMessage.value = props.successDel;
        setTimeout(() => {
            successDelMessage.value = null;
        }, 3000);
    }
});

const form = useForm({
    id: '',
    search_str: props.search_str || ''
});

const deleteOrder = (id, name) => {
    if(confirm(name + 'のオーダーを削除してもよろしいでしょうか？')) {
        form.delete(route('order.destroy', id))
    }
}

const search_go = () => {
    form.get(route('order.index'))
}
</script>

<template>
    <Head title="オーダー一覧" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">オーダー一覧</h2>
        </template>

        <div class="py-12">
            <div class="m-3 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- トーストメッセージ表示 -->
                <transition name="fade">
                    <div v-if="successMessage" class="alert alert-success m-2 mb-4 bg-green-100 p-3 rounded shadow-md">
                        {{ successMessage }}
                    </div>
                </transition>

                <transition name="fade">
                    <div v-if="successDelMessage" class="alert alert-success m-2 mb-4 bg-red-100 p-3 rounded shadow-md">
                        {{ successDelMessage }}
                    </div>
                </transition>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">
                    <div class="mt-3 mb-3 ml-3 flex">
                        <!-- Linkタグを使うことでaタグと違ってページ全体を再読み込みせずにリンクを処理できる -->
                        <Link :href="route('order.create')" :class="'flex justify-center items-center px-4 py-2 mr-3 bg-indigo-500 text-white border rounded-md font-semibold text-xs'" >
                            <i class="fa-solid fa-plus-circle mr-1"></i> オーダー登録
                        </Link>
                        <div>
                            <TextInput
                                id="search_str"
                                type="text"
                                class="block w-full"
                                v-model="form.search_str"
                                autocomplete="search_str"
                                placeholder="検索"
                                @blur="search_go"
                            />
                        </div>
                    </div>

                    <span v-if="props.orders.data.length===0" class="m-2">該当する商品はありません。</span>
                    <table v-else class="table-auto border border-gray-400 w-100 m-3">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2 text-xs border-l border-gray-400">受注日</th>
                                <th class="px-4 py-2 text-xs border-l border-gray-400">顧客</th>
                                <th class="px-4 py-2 text-xs border-l border-gray-400">商品1</th>
                                <th class="px-4 py-2 text-xs">単価</th>
                                <th class="px-4 py-2 text-xs">税率</th>
                                <th class="px-1 py-2 text-xs">注文数</th>
                                <th class="px-4 py-2 text-xs border-l border-gray-400">商品2</th>
                                <th class="px-4 py-2 text-xs">単価</th>
                                <th class="px-4 py-2 text-xs">税率</th>
                                <th class="px-1 py-2 text-xs">注文数</th>
                                <th class="px-4 py-2 text-xs border-l border-gray-400">商品3</th>
                                <th class="px-4 py-2 text-xs">単価</th>
                                <th class="px-4 py-2 text-xs">税率</th>
                                <th class="px-1 py-2 text-xs">注文数</th>
                                <th class="px-4 py-2 border-l border-gray-400"></th>
                                <th class="px-4 py-2"></th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in orders.data" :key="order.id">
                                <td class="border border-gray-400 px-4 py-2 text-center">
                                    {{ order.id }}
                                </td>
                                <td class="border border-gray-400 px-2 py-2 text-center text-xs">
                                    {{ order.order_day }}
                                </td>
                                <td class="border border-gray-400 px-4 py-2">
                                    {{ order.customer.name }}
                                </td>
                                <td class="border-t border-b border-gray-400 px-2 py-2 text-center">
                                    {{ order.product1.name }}
                                </td>
                                <td class="border-t border-b border-gray-400 px-2 py-2 text-center">
                                    {{ order.product1.price }}
                                </td>
                                <td class="border-t border-b border-gray-400 px-2 py-2 text-center">
                                    {{ order.product1.tax }}%
                                </td>
                                <td class="border-t border-b border-r border-gray-400 px-2 py-2 text-center">
                                    {{ order.num1 }}
                                </td>
                                <td class="border-t border-b border-gray-400 px-2 py-2 text-center">
                                    {{ order.product2?.name }}
                                </td>
                                <td class="border-t border-b border-gray-400 px-2 py-2 text-center">
                                    {{ order.product2?.price }}
                                </td>
                                <td class="border-t border-b border-gray-400 px-2 py-2 text-center">
                                    {{ order.product2?.tax }}%
                                </td>
                                <td class="border-t border-b border-r border-gray-400 px-2 py-2 text-center">
                                    {{ order.num2 }}
                                </td>
                                <td class="border-t border-b border-gray-400 px-2 py-2 text-center">
                                    {{ order.product3?.name }}
                                </td>
                                <td class="border-t border-b border-gray-400 px-2 py-2 text-center">
                                    {{ order.product3?.price }}
                                </td>
                                <td class="border-t border-b border-gray-400 px-2 py-2 text-center">
                                    {{ order.product3?.tax }}%
                                </td>
                                <td class="border-t border-b border-gray-400 px-2 py-2 text-center">
                                    {{ order.num3 }}
                                </td>
                                <td class="border border-gray-400 px-4 py-2 text-center">
                                    <Link :href="route('order.show',order.id)"
                                    :class="'px-4 py-2 bg-green-400 text-white border rounded-md text-xs inline-block text-center'"
                                    >
                                        <i class="fa-solid fa-info"></i>
                                    </Link>
                                </td>
                                <td class="border border-gray-400 px-4 py-2 text-center">
                                    <Link
                                    :href="route('order.edit',order.id)"
                                    :class="'px-4 py-2 bg-yellow-400 text-white border rounded-md text-xs inline-block text-center'"
                                    >
                                        <i class="fa-solid fa-edit"></i>
                                    </Link>
                                </td>
                                <td class="border border-gray-400 px-4 py-2 text-center">
                                    <DangerButton
                                        @click="
                                            deleteOrder(order.id, order.customer.name)
                                        ">
                                        <i class="fa-solid fa-trash"></i>
                                    </DangerButton>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <nav class="flex items-center gap-x-1 mt-2 mb-2" aria-label="Pagination">
                        <div class="flex items-center gap-x-1">
                            <div v-for="(link,index) in orders.meta.links">
                                <div v-if="index==0">
                                    <Link :href="route('order.index', { page: orders.meta.current_page-1, search_str: form.search_str })"
                                    v-show="link['url']!=null"
                                    type="button"
                                    class="min-h-[38px] min-w-[38px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m15 18-6-6 6-6"></path>
                                        </svg>
                                        <span>Previous</span>
                                    </Link>
                                </div>
                                <div v-else-if="index==orders.meta.last_page+1">
                                    <Link :href="route('order.index', { page: orders.meta.current_page+1, search_str: form.search_str })"
                                    v-show="link['url']!=null"
                                    type="button"
                                    class="min-h-[38px] min-w-[38px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                                        <span>Next</span>
                                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m9 18 6-6-6-6"></path>
                                        </svg>
                                    </Link>
                                </div>
                                <div v-else>
                                    <Link :href="route('order.index', { page: link['label'], search_str: form.search_str })"
                                        v-if="link['active']===true"
                                        v-show="link['url']!=null"
                                        type="button"
                                        class="min-h-[38px] min-w-[38px] flex justify-center items-center bg-gray-200 text-gray-800 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-300 disabled:opacity-50 disabled:pointer-events-none"
                                        aria-current="page">
                                        <span>{{ link['label'] }}</span>
                                    </Link>
                                    <Link :href="route('order.index', { page: link['label'], search_str: form.search_str })"
                                        v-else
                                        v-show="link['url']!=null"
                                        type="button"
                                        class="min-h-[38px] min-w-[38px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10">
                                        <span>{{ link['label'] }}</span>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </nav>
                    <!-- End Pagination -->
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style>
    /* フェードアウトアニメーション */
    .fade-enter-active, .fade-leave-active {
        transition: opacity 0.5s;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>
