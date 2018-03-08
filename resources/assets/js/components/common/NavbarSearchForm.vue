<template>
	<div class="ml-auto mr-auto col-sm-8 col-md-7 col-lg-5">
		<b-nav-form@submit.prevent="performSearch">
	        <md-field class="reduced-margin-bottom">
		      	<label>I'm looking for</label>
		    	<md-input 
		    		v-model="query"
		    		placeholder="Search here"
		    		autocomplete="off"
		    		></md-input>
		   	</md-field>
	    </b-nav-form>
		<md-list v-if="showSuggestions">
			<md-list-item
				:key="prof.id"
				v-for="prof in profMatches"
			>{{prof.name}}</md-list-item>
		</md-list>
	</div>
</template>

<script>
	import { loadAllProfessorsData } from 'Js/store/api';
	export default {
		name: 'NavbarSearchForm',
		props: {
			schoolData: {
				type: Array,
				required: true,
			},
		},
		created() {
			const {data, beingFetched} = this.$store.state.prof;
			if(!data && !beingFetched) {
				this.$store.commit('updateProfsDataFetchingStatus', true);

				loadAllProfessorsData().then(res => {
					this.$store.commit({
						type: 'updateProfsData',
						data: res.data.profs,
					});
				});
			}
		},
		data() {
			return {
				query: '',
				performingSearch: false,
			};
		},
		computed: {
			schoolMatches() {
				return ['a'];
			},
			profData() {
				return this.$store.state.prof;
			},
			profMatches() {
				const {query, profData} = this;

				return profData.reduce((prof) => {
					const regex = new RegExp(query, 'gi');
					return prof.name.match(regex);
				});
			},
			showSuggestions() {
				return this.query != '' && 
						this.schoolMatches.length > 0 &&
						this.profMatches.length > 0 &&
						this.performingSearch === true;
			},
		},
		methods: {
			performSearch(e) {
				console.log(e.target.value);
			},
			fetchData() {

			}
		},
	};
</script>

<style scoped>
	.reduced-margin-bottom {
		margin-bottom: 5px;
	}
</style>