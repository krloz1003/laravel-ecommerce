<template>
<v-row justify="center">
	<v-dialog v-model="show" max-width="290">
		<v-card>
			<v-card-title class="text-h5">
				Confirmation
			</v-card-title>
			<v-card-text>
				{{ dialog }}
			</v-card-text>
			<v-card-actions>
				<v-spacer></v-spacer>
				<v-btn color="green darken-1" text @click="dialog = false">
					Cancel
				</v-btn>
				<v-btn color="green darken-1" text @click="confirmation()" >
					Continue
				</v-btn>
			</v-card-actions>
		</v-card>
	</v-dialog>
</v-row>
</template>
<script>
export default {
	data () {
	  return {
		show: false,
		dialog: '',
		data: []
	  }
	},
	watch: {
		dialog: function(newVal, oldVal){
			this.show = (newVal)? true : false;
		}
	},
	created: function() {
		this.$parent.$on('dialogStatus', this.dialogStatus);
	},
	methods: {
		dialogStatus(res){
			this.dialog = res.dialog;
			this.data 	= res;
		},
		confirmation(){
			this.dialog = '';
			this.$root.$emit("dialogConfirmation", this.data);
		}
	}
}
</script>