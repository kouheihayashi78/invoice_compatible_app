<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import NavLink from "@/Components/NavLink.vue";

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

const submit = () => {
    form.post(route("order.store"), {
        // onFinishだとバリデーション発生時もリセットされてしまうのでOnSuccess
        onSuccess: () => form.reset("customer_id", "product_id1", "product_id2", "product_id3"),
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
                                class="mt-1 block w-full"
                                v-model="form.customer_id"
                                required
                                autocomplete="name"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.customer_id"
                            />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="product_id1" value="商品1" />

                            <SelectInput
                                :options="products.data"
                                id="product_id1"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.product_id1"
                                required
                                autocomplete="name"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.product_id1"
                            />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="product_id2" value="商品2" />

                            <SelectInput
                                :options="products.data"
                                id="product_id2"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.product_id2"
                                required
                                autocomplete="name"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.product_id2"
                            />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="product_id3" value="商品3" />

                            <SelectInput
                                :options="products.data"
                                id="product_id3"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.product_id3"
                                required
                                autocomplete="name"
                            />

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
