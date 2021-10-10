<template>
<v-row dense>	
	<v-col cols="12">
  		<v-card>
			<v-card-title>
				<v-btn
					tile
					color="success"
					@click="create()"
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
					class="mr-2"
					@click="editUser(item)"
				>edit
				</v-icon>
				<v-icon
					small
					@click="deleteUser(item)"
				>delete
				</v-icon>
			</template>

		</v-data-table>
		<cmp-confirmation />
		<cmp-snackbars />
		<form-user />
	</v-col>
</v-row>
</template>
<script>
import CmpConfirmation from './../CmpConfirmation.vue'
import CmpSnackbars from './../CmpSnackbars.vue'
import FormUser from './FormUser.vue'

export default {
	mounted() {			
		this.getProducts();
		this.$root.$on('dialogConfirmation',(res) => {
			if(res.type == "UPDATE") this.updateUser(res.data);
			if(res.type == "DELETE") this.destroyUser(res.data);
		});
		this.$root.$on('getProducts',res => this.getProducts());
	},
	components: {	
		CmpConfirmation,
		CmpSnackbars,
		FormUser
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
		  { text: 'Email', value: 'email' },
		  { text: 'Created', value: 'created_at' },
		  { text: 'Actions', value: 'actions', sortable: false  },
		],
		rows: [],
	}),
	methods: {
		getProducts(){
			axios.get( `${Laravel.baseUrl}/api/users`)
			.then(response => {
				this.rows = response.data;
			});
		},
		create(row){			
			this.$emit('dialogForm', true);
		},
		store(){
			axios.post( `${Laravel.baseUrl}/product`, this.form)
			.then(response => {
				console.log(response);					
			});			
		},
		editUser(row){			
			this.$emit('dialogForm', true);
			this.$emit('editFormUser', row.id);	
		},
		update(row){
			axios.put( `${Laravel.baseUrl}/product/${row.id}`, row.params)
			.then(response => {
				this.getProducts();
				this.$emit('snackbarShow', response);
			});
		},
		deleteUser(row){
			let dialog = "¿Are you sure to deleted the user?"
			this.$emit('dialogStatus', {type: 'DELETE', dialog: dialog, data: { id: row.id }});
		},
		destroyUser(row){
			axios.delete( `${Laravel.baseUrl}/user/${row.id}`)
			.then(response => {
				this.getProducts();
				this.$emit('snackbarShow', response);
			});
		}
	}
}
</script>