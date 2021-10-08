<template>
<v-row>
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
</v-row>
</template>
<script>
import CmpConfirmation from './../CmpConfirmation.vue'
import CmpSnackbars from './../CmpSnackbars.vue'

export default {
	mounted() {			
		this.getProducts();
		this.$root.$on('dialogConfirmation',(res) => {
			if(res.type == "UPDATE") this.update(res.data);
			if(res.type == "DELETE") this.destroy(res.data);

		});
	},
	components: {	
		CmpConfirmation,
		CmpSnackbars
	},
	props: {
		search: {
			type: String,
			required: false
		}
	},
	data () {
	  return {
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
	  }
	},
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
		editItem(row){
			console.log('Edit', row)
		},
		deleteItem(row){
			let dialog = "¿Are you sure to deleted the product?"
			this.$emit('dialogStatus', {type: 'DELETE', dialog: dialog, data: { id: row.id }});
		},
		update(row){
			axios.put( `${Laravel.baseUrl}/product/${row.id}`, row.params)
			.then(response => {
				this.getProducts();
				this.$emit('snackbarShow', response);
			});
		},
		destroy(row){
			axios.delete( `${Laravel.baseUrl}/product/${row.id}`)
			.then(response => {
				this.getProducts();
				this.$emit('snackbarShow', response);
			});
		}
	}
}
</script>