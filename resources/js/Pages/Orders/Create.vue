<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import NavLink from "@/Components/NavLink.vue";
import { computed } from "vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
    products: {type:Object},
    customers: {type:Object}
})

const form = useForm({
    customer_id: '',
    product_id1 : '',
    product_id2 : '',
    product_id3 : '',
    num1 : '',
    num2 : '',
    num3 : '',
});

// 選択した商品の情報を取得する
const selectedProduct1 = computed(() => {
    return props.products.data.find((product) => product.id == form.product_id1)
});
const selectedProduct2 = computed(() => {
    return props.products.data.find((product) => product.id == form.product_id2)
});
const selectedProduct3 = computed(() => {
    return props.products.data.find((product) => product.id == form.product_id3)
});

const submit = () => {
    form.post(route("order.store"), {
        // onFinishだとバリデーション発生時もリセットされてしまうのでOnSuccess
        onSuccess: () => form.reset("customer_id", "product_id1", "product_id2", "product_id3", "num1", "num2", "num3"),
    });
};
</script>
<template>
    <Head title="オーダー登録" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                オーダー登録
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">オーダー登録</div>
                </div>
            </div>

            <div class="m-3 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <form @submit.prevent="submit">
                        <div class="mt-4">
                            <InputLabel for="customer_id" value="客先" />

                            <SelectInput
                                :options="customers.data"
                                id="customer_id"
                                type="text"
                                class="mt-1 block w-80"
                                v-model="form.customer_id"
                                required
                                autofocus
                                autocomplete="name"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.customer_id"
                            />
                        </div>

                        <div class="mt-4 flex">
                            <div>
                                <InputLabel for="product_id1" value="商品1" />

                                <SelectInput
                                    :options="products.data"
                                    id="product_id1"
                                    type="text"
                                    class="mt-1 block w-80"
                                    v-model="form.product_id1"
                                    required
                                    autocomplete="name"
                                />
                            </div>

                            <!-- 商品1が選択されたら、商品の情報表示、個数を入力するフォームを表示 -->
                            <div v-if="selectedProduct1" class="flex">
                                <div class="ml-10 w-24">
                                    <InputLabel value="コード"/>
                                    <div class="mt-3 ml-2 font-medium text-xl">
                                        {{ selectedProduct1.code }}
                                    </div>
                                </div>
                                <div class="ml-10 w-24">
                                    <InputLabel value="価格"/>
                                    <div class="mt-3 ml-2 font-medium text-xl">
                                        {{ selectedProduct1.price }}円
                                    </div>
                                </div>
                                <div class="ml-10 w-24">
                                    <InputLabel value="税率"/>
                                    <div class="mt-3 ml-2 font-medium text-xl">
                                        {{ selectedProduct1.tax }}%
                                    </div>
                                </div>
                                <!-- 注文数を数字で入力し、データを送信できる様にする -->
                                <div class="ml-10 w-24">
                                    <InputLabel for="num1" value="注文数"/>
                                    <TextInput
                                        v-model="form.num1"
                                        id="num1"
                                        type="number"
                                        class="w-full"
                                        autocomplete="num1"
                                        required
                                    />
                                </div>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.num1"
                                />
                            </div>

                            <InputError
                                class="mt-2"
                                :message="form.errors.product_id1"
                            />
                        </div>

                        <div class="mt-4 flex">
                            <div>
                                <InputLabel for="product_id2" value="商品2" />

                                <SelectInput
                                    :options="products.data"
                                    id="product_id2"
                                    type="text"
                                    class="mt-1 block w-80"
                                    v-model="form.product_id2"
                                    autocomplete="name"
                                />
                            </div>

                            <div v-if="selectedProduct2" class="flex">
                                <div class="ml-10 w-24">
                                    <InputLabel value="コード"/>
                                    <div class="mt-3 ml-2 font-medium text-xl">
                                        {{ selectedProduct2.code }}
                                    </div>
                                </div>
                                <div class="ml-10 w-24">
                                    <InputLabel value="価格"/>
                                    <div class="mt-3 ml-2 font-medium text-xl">
                                        {{ selectedProduct2.price }}円
                                    </div>
                                </div>
                                <div class="ml-10 w-24">
                                    <InputLabel value="税率"/>
                                    <div class="mt-3 ml-2 font-medium text-xl">
                                        {{ selectedProduct2.tax }}%
                                    </div>
                                </div>

                                <div class="ml-10 w-24">
                                    <InputLabel for="num2" value="注文数"/>
                                    <TextInput
                                        v-model="form.num2"
                                        id="num2"
                                        type="number"
                                        class="w-full"
                                        autocomplete="num2"
                                        required
                                    />
                                </div>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.num2"
                                />
                            </div>

                            <InputError
                                class="mt-2"
                                :message="form.errors.product_id2"
                            />
                        </div>

                        <div class="mt-4 flex">
                            <div>
                                <InputLabel for="product_id3" value="商品3" />

                                <SelectInput
                                    :options="products.data"
                                    id="product_id3"
                                    type="text"
                                    class="mt-1 block w-80"
                                    v-model="form.product_id3"
                                    autocomplete="name"
                                />
                            </div>

                            <div v-if="selectedProduct3" class="flex">
                                <div class="ml-10 w-24">
                                    <InputLabel value="コード"/>
                                    <div class="mt-3 ml-2 font-medium text-xl">
                                        {{ selectedProduct3.code }}
                                    </div>
                                </div>
                                <div class="ml-10 w-24">
                                    <InputLabel value="価格"/>
                                    <div class="mt-3 ml-2 font-medium text-xl">
                                        {{ selectedProduct3.price }}円
                                    </div>
                                </div>
                                <div class="ml-10 w-24">
                                    <InputLabel value="税率"/>
                                    <div class="mt-3 ml-2 font-medium text-xl">
                                        {{ selectedProduct3.tax }}%
                                    </div>
                                </div>

                                <div class="ml-10 w-24">
                                    <InputLabel for="num3" value="注文数"/>
                                    <TextInput
                                        v-model="form.num3"
                                        id="num3"
                                        type="number"
                                        class="w-full"
                                        autocomplete="num3"
                                        required
                                    />
                                </div>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.num3"
                                />
                            </div>

                            <InputError
                                class="mt-2"
                                :message="form.errors.product_id3"
                            />
                        </div>

                        <div class="my-5 flex items-center justify-center">
                            <NavLink :href="route('order.index')"
                                :class="'bg-gray-100 rounded-md font-semibold'" >
                                <i class="fa-solid fa-backward mr-2"></i> 戻る
                            </NavLink>
                            <PrimaryButton
                                class="ms-4"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                登録
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
