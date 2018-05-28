<template>
	<ProfileContainer v-if="professor">
		<ProfessorDetailsCard 
			:prof="professor" 
			:school="professor.school"
			:department="professor.department"
			:ratings="ratingsAreReady ? ratings : null"
			:numberOfSimilarProfs="numberOfSimilarProfs"
		></ProfessorDetailsCard>
		<div 
			v-if="ratingsAreReady"
			class="md-layout-item md-size-100 md-layout"
		>
			<p v-if="hasRatings" class="md-layout-item md-title md-size-100">Student Reviews</p>
			<p v-else class="noreview-space"></p>
			<QuickReview :submit="finishReview" target="professor"></QuickReview>
			<ProfessorReview
				class="animated fadeInUp"
				v-if="hasRatings"
				v-for="(rating, i) in ratings"
				:key="rating.id"
				:rating="rating"
				:delay="(i+1) * 200"
			></ProfessorReview>

			<div v-if="! hasRatings" class="md-layout md-alignment-center-center">
				<md-empty-state
					class="md-layout-item"
			      	md-icon="info_outline"
			      	md-label="No reviews for the moment"
			      	md-description="There seems to be no review available for this professor.. Why not be the first to write one?">
			     	<md-button class="md-primary md-raised"
			     		:to="{name: 'rateProfessor', 
			     			params:{
			     				id: professor.id,
			     				slug: professor.slug,
			     			}
			     		}"
			     	>Write a review</md-button>
			    </md-empty-state>
			</div>
		</div>
		<div
			class="md-layout md-alignment-center-center"
			style="margin-top: 3em" 
			v-else
		>
			<md-progress-spinner 
				:md-diameter="60"
				:md-stroke="6"
				md-mode="indeterminate"
			></md-progress-spinner>
		</div>
	</ProfileContainer>
</template>

<script>
	import Fetcher from 'Js/lib/Fetcher';
	import ProfileContainer from '../components/ProfileContainer';
	import ProfessorDetailsCard from '../components/ProfessorDetailsCard';
	import ProfessorReview from '../components/ProfessorReview';
	import QuickReview from '../components/QuickReview';
	import { loadReviews } from 'Js/store/api';

	export default {
		name: 'Professor',
		components: {
			ProfileContainer, ProfessorDetailsCard, ProfessorReview, QuickReview,
		},	
		/**
		 * Fetch the professor's additional data like department and the reviews
		 * @return {Void} 
		 */
		created() {
			Fetcher.depts(this);
		},
		data() {
			return {
				/**
				 * Whether the allow the list of reviews to be shown
				 * @type {Boolean}
				 */
				renderList: false,

				/**
				 * The viewing state of the reviews
				 * @type {Boolean}
				 */
				ratingsAreReady: false,
			};
		},
		computed: {
			/**
			 * Checks if there are any ratings
			 * @return {Boolean} 
			 */
			hasRatings() {
				return this.ratings.length > 0;
			},

			numberOfSimilarProfs() {
				return {
					school: 2,
					department: 7,
				};
			},

			/**
			 * Get the ratings of this professor in view from the store's state
			 * @return {Array} 
			 */
			ratings() {
				return this.$store.state.reviews.inView;
			},

			/**
			 * Determine whether the datas for this page are ready to be used
			 * @return {Boolean} 
			 */
			dataIsReady() {
				return this.$store.getters.profDataIsReady;
			},

			/**
			 * Search for the professor with the given slug in the app's store
			 * @return {Object|Void} 
			 */
			professor() {
				 const {slug} = this.$route.params;
				 const {fullProfessorWithSlug} = this.$store.getters;

				 if(this.dataIsReady) {
				 	return fullProfessorWithSlug(slug);
				}
			},
		},
		watch: {
			/**
			 * When the data is ready and no professor with the given slug exists then redirect
			 * @param  {Boolean} isReady The value of the 'dataIsReady' computed property
			 * @return {Void}          
			 */
			dataIsReady: function(isReady) {
				if(isReady && !this.professor) {
					this.$router.push({name: 'notFound'});
				}

				if(isReady && this.professor) {
					this.loadReviews();
				}
			},
		},
		methods: {
			/**
			 * Navigate to the page finish writing the review
			 * @return {Void} 
			 */
			finishReview() {
				const {id, slug} = this.professor;
				this.$router.push({name: 'rateProfessor', params: {id, slug}});
			},

			/**
			 * Make a request to fetch the approved reviews for this professor
			 * @return {Void} 
			 */
			loadReviews() {
				const params = {
				  	filter_groups: [{
			      		filters: [
					      	{
						        key: 'professor_id',
						        value: this.professor.id,
						        operator: 'eq'
					       	},
					       	{
						        key: 'approved',
						        value: 0,
						        operator: 'eq'
					       	},
				      	]
			    	}]
				};

				loadReviews(params).then(({data}) => {
					this.ratingsAreReady = true;
					this.$store.commit({
						type: 'updateTheReviewsInView',
						reviews: data.reviews, 
					});
				})
				.catch(err => {
					console.log(err);
					this.ratingsAreReady = true;
				});
			}
		},
	};
</script>

<style scoped>
	.md-title {
		margin: 2em 0;
	}
	.noreview-space {
		margin-top: 2em;
		width: 100%;
	}
</style>