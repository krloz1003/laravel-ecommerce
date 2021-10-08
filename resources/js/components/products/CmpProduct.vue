<template>
<v-row dense>
	<v-col cols="12">
		<form-product />
	</v-col>
	<v-col cols="12">
  		<v-card>
			<v-card-title>
				Products
				<v-spacer></v-spacer>
				<v-text-field
					v-model="search"
					append-icon="mdi-magnify"
					label="Search"
					single-line
					hide-details
				></v-text-field>
			</v-card-title>
			<tbl-products :search="search"></tbl-products>
		</v-card>
	</v-col>
</v-row>
</template>
<script>
	import TblProducts from './TblProducts.vue'
	import FormProduct from './FormProduct.vue'
	export default {
		mounted() {			
			
		},
		components: {
			TblProducts,
			FormProduct
		},
		data: () => ({
			loading: false,
			selection: 1,
			rows: [],
			search: ''
		}),
		methods: {
			reserve () {
				this.loading = true
				setTimeout(() => (this.loading = false), 2000)
			},
			getProducts(){
				axios.get( `${Laravel.baseUrl}/api/products`)
				.then(response => {
					this.rows = response.data;
				});
			},
		}
	}
</script>