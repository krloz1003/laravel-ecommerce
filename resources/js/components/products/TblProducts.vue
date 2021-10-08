<template>
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
</template>
<script>
  export default {
	mounted() {			
		this.getProducts();
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
			console.log('Status', row)
		},
		editItem(row){
			console.log('Edit', row)
		},
		deleteItem(row){
			console.log('Delete', row)
		}
	}
  }
</script>