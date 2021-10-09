<template>
<v-row dense>	
	<v-col cols="12">
  		<v-card>
			<v-card-title>
				<v-btn
					tile
					color="success"
					@click="createItem()"
				>
					<v-icon left>
						add
					</v-icon>
					Add
				</v-btn>
				<v-spacer></v-spacer>
				<v-text-field
					v-model="search"
					append-icon="mdi-magnify"
					label="Search"
					single-line
					hide-details
				></v-text-field>
			</v-card-title>			
		</v-card>
	</v-col>
	<v-col cols="12">
		<v-data-table
			:headers="headers"
			:items="rows"
			:search="search"
			:items-per-page="5"
			class="elevation-1"
		>
			<template v-slot:item.status="{ item }">
				<v-chip :color="getColor(item.status)" dark x-small >
					{{ (item.status)? 'ENABLED' : 'DISABLED' }}
				</v-chip>
			</template>
			<template v-slot:item.actions="{ item }">
				<v-icon
					small
					@click="statusItem(item)"
				>autorenew
				</v-icon>
				<v-icon
					small
					class="mr-2"
					@click="editItem(item)"
				>edit
				</v-icon>
				<v-icon
					small
					@click="deleteItem(item)"
				>delete
				</v-icon>
			</template>

		</v-data-table>
		<cmp-confirmation />
		<cmp-snackbars />
		<form-product />
	</v-col>
</v-row>
</template>
<script>
import CmpConfirmation from './../CmpConfirmation.vue'
import CmpSnackbars from './../CmpSnackbars.vue'
import FormProduct from './FormProduct.vue'

export default {
	mounted() {			
		this.getProducts();
		this.$root.$on('dialogConfirmation',(res) => {
			if(res.type == "UPDATE") this.updateItem(res.data);
			if(res.type == "DELETE") this.destroyItem(res.data);
		});
		this.$root.$on('getProducts',res => this.getProducts());
	},
	components: {	
		CmpConfirmation,
		CmpSnackbars,
		FormProduct
	},
	data: () => ({
		selection: 1,
		rows: [],
		search: '',
		headers: [
		  {
			text: '#',
			align: 'start',
			sortable: false,
			value: 'id',
		  },
		  { text: 'Name', value: 'name' },
		  { text: 'Description', value: 'description' },
		  { text: 'Price ($)', value: 'price' },
		  { text: 'Status', value: 'status' },
		  { text: 'Actions', value: 'actions', sortable: false  },
		],
		rows: [],
	}),
	methods: {
		getProducts(){
			axios.get( `${Laravel.baseUrl}/api/products`)
			.then(response => {
				this.rows = response.data;
			});
		},
		getColor(row){
			return (row)? 'green' : 'red';
		},
		statusItem(row){
			let dialog = "¿Are you sure to updated the status ?"
			this.$emit('dialogStatus', {type: 'UPDATE', dialog: dialog, data: { id: row.id, params: { status: !row.status }}});
		},
		createItem(row){			
			this.$emit('dialogFormProd', true);
		},
		storeItem(){
			axios.post( `${Laravel.baseUrl}/product`, this.form)
			.then(response => {
				console.log(response);					
			});			
		},
		editItem(row){			
			this.$emit('dialogFormProd', true);
			this.$emit('editFormItem', row.id);	
		},
		updateItem(row){
			axios.put( `${Laravel.baseUrl}/product/${row.id}`, row.params)
			.then(response => {
				this.getProducts();
				this.$emit('snackbarShow', response);
			});
		},
		deleteItem(row){
			let dialog = "¿Are you sure to deleted the product?"
			this.$emit('dialogStatus', {type: 'DELETE', dialog: dialog, data: { id: row.id }});
		},

		destroyItem(row){
			axios.delete( `${Laravel.baseUrl}/product/${row.id}`)
			.then(response => {
				this.getProducts();
				this.$emit('snackbarShow', response);
			});
		}
	}
}
</script>