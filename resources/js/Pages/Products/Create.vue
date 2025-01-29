<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import SelectInput from "@/Components/SelectInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import NavLink from "@/Components/NavLink.vue";

const taxList = [
    {
        id: 1,
        name: '10%'
    },
    {
        id: 8,
        name: '8%'
    },
    {
        id: 0,
        name: '非課税'
    }
];

const form = useForm({
    name: "",
    code: "",
    price: "",
    tax: "",
});

const submit = () => {
    form.post(route("register"), {
        // onFinishだとバリデーション発生時もリセットされてしまうのでOnSuccess
        onSuccess: () => form.reset("name", "code", "price", "tax"),
    });
};
</script>
<template>
    <Head title="商品登録" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                商品登録
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">商品登録</div>
                </div>
            </div>

            <div class="m-3 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">
                    <form @submit.prevent="submit">
                        <div class="mt-4">
                            <InputLabel for="name" value="Name" />

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.name"
                            />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="code" value="Code" />

                            <TextInput
                                id="code"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.code"
                                required
                                autocomplete="name"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.code"
                            />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="price" value="Price" />

                            <TextInput
                                id="price"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.price"
                                required
                                autocomplete="name"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.price"
                            />
                        </div>

                        <div class="mt-4">
                            <InputLabel for="tax" value="Tax" />

                            <SelectInput
                                :options="taxList"
                                id="tax"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.tax"
                                required
                                autocomplete="name"
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.tax"
                            />
                        </div>

                        <div class="my-5 flex items-center justify-center">
                            <NavLink :href="route('product.index')"
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
