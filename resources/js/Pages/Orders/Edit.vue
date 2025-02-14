<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import { Head, useForm } from "@inertiajs/vue3";
import NavLink from "@/Components/NavLink.vue";
import { computed, nextTick, ref } from "vue";
import TextInput from "@/Components/TextInput.vue";
import { productNum1, productNum2, productNum3 } from "@/const/Product";

// Modalのために追加
import SearchButton from '@/Components/SearchButton.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    order: {type:Object},
    products: {type:Object},
    customers: {type:Object},
})

// modalの初期化
const confirmingUserDeletion = ref(false);
const searchInput = ref(null);
const selectProductNum = ref(null);
const searchResult = ref([])

const form = useForm({
    customer_id: props.order.order_customer_id,
    product_id1 : props.order.order_product_id1,
    product_id2 : props.order.order_product_id2,
    product_id3 : props.order.order_product_id3,
    num1 : String(props.order.order_num1),
    num2 : String(props.order.order_num2),
    num3 : String(props.order.order_num3),
    search_str : '',
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

// ここからModalの処理
const confirmUserDeletion = (number) => {
    selectProductNum.value = number;
    confirmingUserDeletion.value = true;

    nextTick(() => searchInput.value.focus());
};

// もし検索バーに文字を入力すると、
const searchItem = () => {
    if(form.search_str.length > 0) {
        const query = form.search_str
        searchResult.value = props.products.data.filter(product => {
            return product.name.includes(query)
        })
    }
    // 下記はget通信で検索したデータを取得していたが、すでに商品は取得しており、かつモーダルの中で非同期的に商品のみを検索したいため、上記のfilterで検索をする
    // form.get(route('order.create'), {
    //     preserveScroll: true,
    //     onError: () => searchInput.value.focus(),
    //     onFinish: () => form.reset(),
    // });
};

const closeModal = () => {
    selectProductNum.value = '';
    confirmingUserDeletion.value = false;
    searchInput.value = ''
    searchResult.value = ''
    form.search_str = ''

    form.clearErrors();
};

const getProduct = (product) => {

    switch (selectProductNum.value) {
        case productNum1:
            form.product_id1 = product.id;
            break;
        case productNum2:
            form.product_id2 = product.id;
            break;
        case productNum3:
            form.product_id3 = product.id;
            break;
        default:
            break;
    }
    closeModal()

}
// ここまでModalの処理

const submit = () => {
    form.post(route("order.store"), {
        // onFinishだとバリデーション発生時もリセットされてしまうのでOnSuccess
        onSuccess: () => form.reset("customer_id", "product_id1", "product_id2", "product_id3", "num1", "num2", "num3"),
    });
};
</script>
<template>
    <Head title="オーダー更新" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                オーダー更新
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">オーダー更新</div>
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

                            <div v-else="selectedProduct1" class="ml-5 mt-7">
                                <PrimaryButton @click="confirmUserDeletion(productNum1)" class="px-4 py-2 text-white border rounded-md font-semibold text-xs">
                                    検索
                                </PrimaryButton>
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
                                    />
                                </div>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.num2"
                                />
                            </div>

                            <div v-else="selectedProduct2" class="ml-5 mt-7">
                                <PrimaryButton @click="confirmUserDeletion(productNum2)" class="px-4 py-2 text-white border rounded-md font-semibold text-xs">
                                    検索
                                </PrimaryButton>
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
                                    />
                                </div>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.num3"
                                />
                            </div>

                            <div v-else="selectedProduct3" class="ml-5 mt-7">
                                <PrimaryButton @click="confirmUserDeletion(productNum3)" class="px-4 py-2 text-white border rounded-md font-semibold text-xs">
                                    検索
                                </PrimaryButton>
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
                                更新
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    商品検索
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    文字列から商品を検索できます。
                </p>

                <div class="mt-6">
                    <InputLabel for="search" value="Search" class="sr-only" />

                    <TextInput
                        id="search"
                        ref="searchInput"
                        v-model="form.search_str"
                        type="text"
                        class="mt-1 block w-3/4"
                        placeholder="文字を入力"
                        @input="searchItem"
                    />

                    <InputError :message="form.errors.search" class="mt-2" />

                    <div v-if="searchResult" class="">
                        <div
                            v-for="product in searchResult"
                            :key="product.id"
                            class="flex cursor-pointer hover:bg-gray-200 p-2 transition"
                            @click="getProduct(product)"
                        >
                            <span class="px-2 py-2 text-center">{{ product.name }}</span>
                            <span class="px-2 py-2 text-center">{{ product.code }}</span>
                            <span class="px-2 py-2 text-center">{{ product.price }}</span>
                            <span class="px-2 py-2 text-center">{{ product.tax }}</span>
                        </div>
                    </div>
                    <div v-else class="">
                        検索結果がありません
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <SearchButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="searchItem"
                    >
                        検索
                    </SearchButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
