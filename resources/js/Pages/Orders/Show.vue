<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps({
    order: { type: Object },
});
</script>
<template>
    <Head title="オーダー詳細" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                オーダー詳細
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mt-3 mb-3 flex">
                    <Link
                        :href="route('order.index')"
                        :class="'px-4 py-2 bg-indigo-500 text-white border rounded-md font-semibold text-xs'"
                    >
                        <i class="fa-solid fa-backward mr-2"></i>戻る
                    </Link>
                </div>

                <form @submit.prevent="submit" class="w-3/4">
                    <div class="flex">
                        <div class="w-32 mr-3">
                            <InputLabel for="order_id" value="ID" />
                            <div class="ml-2 font-semibold text-xl">
                                {{ props.order.data.id }}
                            </div>
                        </div>
                        <div class="w-72 mr-3">
                            <InputLabel for="order_id" value="注文日" />
                            <div class="ml-2 font-semibold text-xl">
                                <!-- sv-SEロケールはYYYY-MM-DD形式の日付文字列を戻す -->
                                {{ new Date(props.order.data.order_day).toLocaleDateString("sv-SE") }}
                            </div>
                        </div>
                        <div>
                            <InputLabel for="customer_id" value="客先" />
                            <div class="ml-2 font-semibold text-xl">
                                {{ props.order.data.customer.name }}
                            </div>
                        </div>
                    </div>

                    <!--ここから小計-->
                    <div class="mt-4 flex">
                        <table class="table-auto border border-gray-400 w-10/12">
                            <thead>
                                <tr class="bg-blue-100">
                                    <th class="px-4 py-2"></th>
                                    <th class="px-4 py-2 text-xs">
                                        お買い上げ額合計（円）
                                    </th>
                                    <th class="px-4 py-2 text-xs">
                                        消費税額合計（円）
                                    </th>
                                    <th class="px-4 py-2 text-xs">
                                        ご請求金額（円）
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white">
                                    <td class="border border-gray-400 px-4 py-2 text-center">
                                        通常税率（10%）
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2 text-center">
                                        {{ props.order.normal_tax_total }}円
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2 text-center">
                                        {{ props.order.normal_tax }}円
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2 text-center" rowspan="2">
                                        {{ props.order.total }}円
                                    </td>
                                </tr>
                                <tr class="bg-white">
                                    <td class="border border-gray-400 px-4 py-2 text-center">
                                        軽減税率（ 8%）
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2 text-center">
                                        {{ props.order.reduced_tax_total }}円
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2 text-center">
                                        {{ props.order.reduced_tax }}円
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--ここまで小計-->

                    <!--ここから明細-->
                    <div class="mt-4">
                        <InputLabel for="" value="明細" />
                    </div>
                    <div class="mt-4 flex">
                        <table class="table-auto border border-gray-400 w-10/12">
                            <thead>
                                <tr class="bg-blue-100">
                                    <th class="px-4 py-2">商品</th>
                                    <th class="px-4 py-2 text-xs">コード</th>
                                    <th class="px-4 py-2 text-xs">価格</th>
                                    <th class="px-4 py-2 text-xs">税率</th>
                                    <th class="px-4 py-2 text-xs">注文数</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white">
                                    <td class="border border-gray-400 px-4 py-2 text-center">
                                        {{ props.order.data.product1.name }}
                                        <span v-if="props.order.data.product1.tax == 8">※</span>
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2 text-center">
                                        {{ props.order.data.product1.code }}
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2 text-center">
                                        {{ props.order.data.product1.price }}円
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2 text-center">
                                        {{ props.order.data.product1.tax }}%
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2 text-center">
                                        {{ props.order.data.num1 }}
                                    </td>
                                </tr>
                                <tr
                                    v-if="props.order.data.product2?.name"
                                    class="bg-white"
                                >
                                    <td class="border border-gray-400 px-4 py-2 text-center">
                                        {{ props.order.data.product2.name }}
                                        <span v-if="props.order.data.product2.tax == 8">※</span>
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2 text-center">
                                        {{ props.order.data.product2.code }}
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2 text-center">
                                        {{ props.order.data.product2.price }}円
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2 text-center">
                                        {{ props.order.data.product2.tax }}%
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2 text-center">
                                        {{ props.order.data.num2 }}
                                    </td>
                                </tr>
                                <tr
                                    v-if="props.order.data.product3?.name"
                                    class="bg-white"
                                >
                                    <td class="border border-gray-400 px-4 py-2 text-center">
                                        {{ props.order.data.product3.name }}
                                        <span v-if="props.order.data.product3.tax == 8">※</span>
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2 text-center">
                                        {{ props.order.data.product3.code }}
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2 text-center">
                                        {{ props.order.data.product3.price }}円
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2 text-center">
                                        {{ props.order.data.product3.tax }}%
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2 text-center">
                                        {{ props.order.data.num3 }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>※軽減税率対象</div>
                    <!--ここまで明細-->

                    <div class="flex items-center mt-8 mb-8">
                        <PrimaryButton class="ms-4" @click="handleSubmit">
                            請求書発行
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
