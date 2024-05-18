<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

const form = useForm({
   design: '',
   price: null,
   quantity: null,
});

</script>

<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Create product page</h2>
        </template>
        <div class="py-12">
            <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
                <div class="p-4 bg-white shadow sm:p-8 sm:rounded-lg">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Creating a new product</h2>
                            <p class="mt-1 text-sm text-gray-600">
                                Create your new product by filling this form and then just submit while done.
                            </p>
                        </header>

                        <form @submit.prevent="form.post(route('products.store'), { onSuccess: () => form.reset() })" class="mt-6 space-y-6">
                            <div>
                                <InputLabel for="design" value="DESIGN" />
                                <TextInput
                                    id="design"
                                    v-model="form.design"
                                    placeholder="Enter a alphabetic name for your product"
                                    type="text"
                                    class="block w-full mt-1"
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
                                    placeholder="Enter a positive value for the price"
                                    max="9999"
                                    step="0.01"
                                    class="block w-full mt-1"
                                />
                                <InputError :message="form.errors.price" class="mt-2" />
                            </div>
                            <div>
                                <InputLabel for="quantity" value="QUANTITY" />
                                <TextInput
                                    id="quantity"
                                    v-model="form.quantity"
                                    type="number"
                                    placeholder="Enter a positive value for the quantity"
                                    min="0"
                                    class="block w-full mt-1"
                                />
                                <InputError :message="form.errors.quantity" class="mt-2" />
                            </div>
                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">Create</PrimaryButton>
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
