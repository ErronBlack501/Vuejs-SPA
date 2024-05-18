<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import DangerButton from '@/Components/DangerButton.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import { defineProps, ref, onUnmounted, onMounted } from "vue";
    import { Link, useForm } from '@inertiajs/vue3';
    import Swal from 'sweetalert2'
    import Chart from 'chart.js/auto';

    defineProps(['products', 'totalAmount', 'minAmount', 'maxAmount']);
    let histogram = ref(null);
    const deleteForm = useForm({});
    const showMethod = (product) => {
        Swal.fire({
            title: "<h1>Data information</h1>",
            icon: "info",
            html: `<p>DESIGN: ` + product.design + `</p>
               <p>PRICE: ` + product.price + `</p>
               <p>QUANTITY: ` + product.quantity + `</p>
               <p>AMOUNT: ` + parseFloat(product.price) * parseInt(product.quantity) + `</p>
            `,
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: 'OK',
            confirmButtonAriaLabel: "OK",
            cancelButtonText: 'Return',
            cancelButtonAriaLabel: "Return"
        })
    }
    const createdSuccessfully = (flash) => {
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: flash,
            showConfirmButton: false,
            timer: 2500
        });
    }

    const deleteMethod = (id) => {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                deleteForm.delete(route('products.destroy', id))
                Swal.fire({
                    title: "Deleted!",
                    text: "The product has been deleted.",
                    icon: "success"
                });
            }
        });
    }

     const chart = (totalAmount, minAmount, maxAmount) => {
        // Données de l'histogramme
        const data = {
            labels: ["Total Amount", "Min Amount", "Max Amount"],
            datasets: [{
                label: 'Product amount statistics',
                data: [ totalAmount, minAmount, maxAmount ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)', // Couleur pour Total Montant
                    'rgba(54, 162, 235, 0.2)', // Couleur pour Min Montant
                    'rgba(255, 206, 86, 0.2)', // Couleur pour Max Montant
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                ],
                borderWidth: 1
           }]
       };
       // Options du graphique
       const options = {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        // Récupérer le canevas
        const ctx = document.getElementById('histogram').getContext('2d');
        // Initialiser le graphique avec Chart.js
        histogram = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options
        });
    }
    const destroy = () => {
        if (histogram) {
            histogram.destroy();
            histogram = null;
        }
    }

    onMounted(chart);
    onMounted(destroy);
    onUnmounted(destroy);
</script>

<template>

    <Head title="Products" />

    <AuthenticatedLayout>
        <div class="h-screen p-5 bg-white">
            <h1 class="text-xl text-center text-black bg-white rounded-md shadow-md">LIST OF PRODUCTS</h1>
            <br>
            <div v-if="$page.props.flash.success">
                {{ createdSuccessfully($page . props . flash . success) }}
            </div>
            <PrimaryButton>
                <Link :href="route('products.create')">Create</Link>
            </PrimaryButton>
            <br>
            <br>
            <table class="w-full bg-white rounded-md shadow-md table-auto">
                <thead class="border-b-2 border-gray-200 bg-gray-50">
                    <tr>
                        <th class="text-center">NUM_PRODUCT</th>
                        <th class="text-center">DESIGN </th>
                        <th class="text-center">PRICE</th>
                        <th class="text-center">QUANTITY</th>
                        <th class="text-center">AMOUNT</th>
                        <th class="text-center">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(product, index) in products" :key="index"
                        :class="{ 'bg-gray-100': index % 2 === 0, 'bg-white': index % 2 !== 0 }">
                        <td class="text-center ">{{ product . id }}</td>
                        <td class="text-center">{{ product . design }}</td>
                        <td class="text-center">{{ product . price }}</td>
                        <td class="text-center">{{ product . quantity }}</td>
                        <td class="text-center">{{ parseFloat(product . price) * parseInt(product . quantity) }}</td>
                        <td class="text-center">
                            <div class="flex justify-center">
                                <PrimaryButton class="my-2 mr-2">
                                    <Link :href="route('products.edit', product.id)">Edit</Link>
                                </PrimaryButton>
                                <PrimaryButton class="my-2 mr-2" @click="showMethod(product)">
                                    Show
                                </PrimaryButton>
                                <DangerButton class="my-2 mr-2" @click="deleteMethod(product.id)">
                                    Delete
                                </DangerButton>
                            </div>
                        </td>
                    </tr>
                </tbody>
                <tfoot class="border-b-2 border-gray-200 bg-gray-50">
                    <tr>
                        <td class="my-4 text-center" colspan="2">MIN AMOUNT: {{ minAmount }}</td>
                        <td class="my-4 text-center" colspan="2">MAX AMOUNT: {{ maxAmount }}</td>
                        <td class="my-4 text-center" colspan="2">TOTAL AMOUNT: {{ totalAmount }}</td>
                    </tr>
                </tfoot>
            </table>
            <br>
            <div>
                <PrimaryButton class="my-2 mr-2" @click="chart(totalAmount, minAmount, maxAmount)">
                                Chart
                </PrimaryButton>
                <DangerButton class="my-2 mr-2" @click="destroy">
                                Destroy
                </DangerButton>
                <br>
                <div class="chart">
                    <canvas id="histogram"></canvas>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>

<style>
   .chart {
        width: 900px;
    }
</style>
