<template>
	<div class="text-center">
		<v-snackbar v-model="snackbar" :multi-line="multiLine" :right="true" :top="true">
			{{ text }}
			<template v-slot:action="{ attrs }">
				<v-btn color="red" text	v-bind="attrs" @click="snackbar = false">
					Close
				</v-btn>
			</template>
		</v-snackbar>
	</div>
</template>
<script>
export default {
	data: () => ({
		multiLine: true,
		snackbar: false,
		text: '',
	}),
	created: function() {
		this.$parent.$on('snackbarShow', this.snackbarShow);
	},
	methods: {
		snackbarShow(res){			
			this.snackbar = true;
			this.text = res.data.message;
		},
	}
}
</script>