<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

const product = defineProps({
        product: {
            type: Object,
        },
});

const form = useForm({
    id: product.product.id,
   design: product.product.design,
   price: product.product.price,
   quantity: product.product.quantity,
});

</script>

<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit product page</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Editing the selected product</h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Edit the product that you have selected whenever you like by changing the content of the form fields and then just submit while you satisfied.
                            </p>
                        </header>

                        <form @submit.prevent="form.put(route('products.update', form.id), { onSuccess: () => form.reset() })" class="mt-6 space-y-6">
                            <div>
                                <InputLabel for="design" value="DESIGN" />
                                <TextInput
                                    id="design"
                                    v-model="form.design"
                                    type="text"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.design" class="mt-2" />
                            </div>
                            <div>
                                <InputLabel for="price" value="PRICE" />
                                <TextInput
                                    id="price"
                                    v-model="form.price"
                                    type="number"
                                    min="0"
                                    max="9999"
                                    step="0.01"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.price" class="mt-2" />
                            </div>
                            <div>
                                <InputLabel for="quantity" value="QUANTITY" />
                                <TextInput
                                    id="quantity"
                                    v-model="form.quantity"
                                    type="number"
                                    min="0"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.quantity" class="mt-2" />
                            </div>
                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                                <PrimaryButton>
                                    <Link :href="route('products.index')">Cancel</Link>
                                </PrimaryButton>
                                <!-- <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Created successfully.</p>
                                </Transition> -->
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
