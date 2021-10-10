<template>
 <v-row justify="center">
	<v-dialog
		v-model="show"
		persistent
		max-width="600px"
	>
		<v-card>
			<v-card-title>
				<span class="text-h5">New user</span>
			</v-card-title>
			<v-card-text>
				<v-container>
					<v-form v-model="valid">
						<v-row>
							<v-col cols="12">
								<v-text-field
									label="Name *"
									type="text"
									v-model="form.name"
									:rules="rules.name"
									required
								></v-text-field>
							</v-col>
			        <v-col cols="12" >
			          <v-text-field
			            v-model="form.email"
			            :rules="rules.email"
			            label="E-mail *"
			            required
			          ></v-text-field>
			        </v-col>
							<v-col cols="12">
          			<v-text-field
									v-model="form.password"
          				:rules="rules.password"
            			label="Password *"
            			type="password"
            			required
          			></v-text-field>
        			</v-col>
							<v-col cols="12">
          			<v-text-field
									v-model="form.password_confirmation"
          				:rules="rules.password_confirmation"
            			label="Password confirmation *"
            			type="password"
            			required
          			></v-text-field>
        			</v-col>        			
						</v-row>
					</v-form>
				</v-container>
				<small>* Indicates required field</small>
			</v-card-text>
			<v-card-actions>
				<v-spacer></v-spacer>
				<v-btn
					color="blue darken-1"
					text
					@click="show = false"
				>
				Close
				</v-btn>
				<v-btn
					color="blue darken-1"
					text
					@click="storeItem()"
				>
				Save
				</v-btn>
			</v-card-actions>
		</v-card>
	</v-dialog>
</v-row>
</template>
<script>
export default {
	data: () => ({
		show: false,
		valid: false,
		form: {
			id: '',
			name: '',
			email: '',
			password: '',
			password_confirmation: ''
		},
		rules: {
			name: [
				v => !!v || 'Name is required',
				v => v.length >= 7 || 'The Name must be at least 7 characters.',
				v => v.length <= 50 || 'The Name may not be greater than 50 characters.',
			],
			email: [
				v => !!v || 'E-mail is required',
        		v => /.+@.+/.test(v) || 'E-mail must be valid',
			],
			password: [
				v => !!v || 'Password is required',
				v => v.length >= 8 || 'The Password must be at least 8 characters.',
			],
			password: [
				v => !!v || 'Password confirmation is required',
				v => v.length >= 8 || 'The Password confirmation must be at least 8 characters.',
			],			
		}

	}),
	created: function() {
		this.$parent.$on('dialogForm', this.showDialog);
		this.$parent.$on('editFormUser', this.editUser);
	},
	methods: {
		showDialog(){
			this.show = true;
		},
		editUser(id){
		console.log(id);
			axios.get( `${Laravel.baseUrl}/user/${id}`)
			.then(res => {
				console.log(res);
				this.form.id = res.data.id;
				this.form.name = res.data.name;
				this.form.email = res.data.email;
			});
		},
		storeItem(){
			if(!this.valid) return false;

			let id = this.form.id;
			let send = (id) 
			? axios.put( `${Laravel.baseUrl}/user/${id}`, this.form) 
			: axios.post( `${Laravel.baseUrl}/user`, this.form)		
			
			send.then(res => {
				this.form.name = '';
				this.form.email = '';
				this.form.password = '';
				this.form.password_confirmation = ''
				this.$root.$emit('getProducts');
				this.show = false;
				this.validate = false;
			});
			
		}
	}
}
</script>