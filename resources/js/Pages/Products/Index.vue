<script setup>
import { ref, watch } from 'vue';
import DangerButton from '@/Components/DangerButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';

// 下記の書き方でcontrollerから渡された変数をvueファイルの中で扱うことができる
const props = defineProps({
    productList: {type: Object},
    search_str: String,
    success: String
});

// フラッシュメッセージをリアクティブな変数として定義して監視
const successMessage = ref(props.success);

// 3秒後にメッセージを消す
watch(successMessage, (newVal) => {
    if (newVal) {
        setTimeout(() => {
            successMessage.value = '';
        }, 3000);
    }
}, {
    // 初期呼び出し
    immediate: true
});

const form = useForm({
    id: '',
    search_str: props.search_str || ''
});

const deleteProduct = (id, name) => {
    if(confirm(name + 'を削除してもよろしいでしょうか')){
        form.delete(route('product.destroy', id));
    }
}

// 検索バーがフォーカスを失ったら発火
const search_go = () => {
    form.get(route('product.index'));
}
</script>

<template>
    <Head title="商品一覧" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品一覧</h2>
        </template>

        <div class="py-12">
            <div class="m-3 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- トーストメッセージ表示 -->
                <transition name="fade">
                        <div v-if="successMessage" class="alert alert-success m-2 mb-4 bg-green-100 p-3 rounded shadow-md">
                            {{ successMessage }}
                        </div>
                    </transition>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">
                    <div class="mt-3 mb-3 ml-3 flex">
                        <!-- Linkタグを使うことでaタグと違ってページ全体を再読み込みせずにリンクを処理できる -->
                        <Link :href="route('product.create')" :class="'flex justify-center items-center px-4 py-2 mr-3 bg-indigo-500 text-white border rounded-md font-semibold text-xs'" >
                            <i class="fa-solid fa-plus-circle mr-1"></i> 商品登録
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

                    <span v-if="props.productList.data.length===0" class="m-2">該当する商品はありません。</span>
                    <table v-else class="table-auto border border-gray-400 w-10/12 m-3">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 w-12">ID</th>
                                <th class="px-4 py-2 w-48">商品</th>
                                <th class="px-4 py-2 w-28">コード</th>
                                <th class="px-4 py-2 w-28 text-center">価格</th>
                                <th class="px-4 py-2 w-28 text-center">税率</th>
                                <th class="px-4 py-2"></th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in productList.data" :key="product.product_id">
                                <td class="border border-gray-400 px-4 py-2 text-center">{{ product.product_id }}</td>
                                <td class="border border-gray-400 px-4 py-2">{{ product.product_name }}</td>
                                <td class="border border-gray-400 px-4 py-2 text-center">{{ product.product_code }}</td>
                                <td class="border border-gray-400 px-4 py-2 text-right">{{ product.product_price }}</td>
                                <td class="border border-gray-400 px-4 py-2 text-right">{{ product.product_tax }}%</td>
                                <td class="border border-gray-400 px-4 py-2 text-center">
                                    <Link
                                        :href="route('product.edit', product.product_id)"
                                        :class="'border rounded-md bg-blue-400 text-white text-xs px-4 py-2'">
                                            <i class="fa-solid fa-edit"></i>
                                    </Link>
                                </td>
                                <td class="border border-gray-400 px-4 py-2 text-center">
                                    <DangerButton
                                        @click="deleteProduct(product.product_id, product.product_name)"
                                        :class="'border rounded-md bg-red-400 text-white text-xs px-4 py-2'">
                                            <i class="fa-solid fa-trash"></i>
                                    </DangerButton>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <nav class="flex items-center gap-x-1 mt-2 mb-2" aria-label="Pagination">
                        <div class="flex items-center gap-x-1">
                            <div v-for="(link,index) in productList.links">
                                <!-- 前ページに戻るアイコン -->
                                <div v-if="index==0">
                                    <Link :href="route('product.index', { page: productList.current_page-1, search_str: form.search_str })"
                                    v-show="link['url']!=null"
                                    type="button"
                                    class="min-h-[38px] min-w-[38px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10"
                                    >
                                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m15 18-6-6 6-6"></path>
                                        </svg>
                                        <span>Previous</span>
                                    </Link>
                                </div>
                                <!-- 次ページに進むアイコン -->
                                <div v-else-if="index==productList.last_page+1"><!-- last_page+1がある場合は次に進めるということでもあるため-->
                                    <Link :href="route('product.index', { page: productList.current_page+1, search_str: form.search_str })"
                                    v-show="link['url']!=null"
                                    type="button"
                                    class="min-h-[38px] min-w-[38px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10"
                                    >
                                        <span>Next</span>
                                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m9 18 6-6-6-6"></path>
                                        </svg>
                                    </Link>
                                </div>
                                <!-- 数字の部分 -->
                                <div v-else>
                                    <!-- 現在開いているページのページネート -->
                                    <Link :href="route('product.index', { page: link['label'], search_str: form.search_str })"
                                        v-if="link['active']===true"
                                        v-show="link['url']!=null"
                                        type="button"
                                        class="min-h-[38px] min-w-[38px] flex justify-center items-center bg-gray-200 text-gray-800 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-300 disabled:opacity-50 disabled:pointer-events-none"
                                        aria-current="page"
                                    >
                                        <span>{{ link['label'] }}</span>
                                    </Link>
                                    <!-- 他のページのページネート -->
                                    <Link :href="route('product.index', { page: link['label'], search_str: form.search_str })"
                                        v-else
                                        v-show="link['url']!=null"
                                        type="button"
                                        class="min-h-[38px] min-w-[38px] flex justify-center items-center text-gray-800 hover:bg-gray-100 py-2 px-3 text-sm rounded-lg focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10"
                                    >
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
