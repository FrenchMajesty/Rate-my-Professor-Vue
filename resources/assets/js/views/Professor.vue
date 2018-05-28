<template>
	<ProfileContainer v-if="professor">
		<ProfessorDetailsCard 
			:prof="professor" 
			:school="professor.school"
			:department="professor.department"
			:ratings="ratingsAreReady ? ratings : null"
			:numberOfSimilarProfs="numberOfSimilarProfs"
		></ProfessorDetailsCard>

		<ReviewsContainer 
			:is-ready="dataIsReady"
			:has-ratings="hasRatings"
			:buttonTarget="buttonTarget"
			profileType="professor" 
		>
			<QuickReview :submit="finishReview" profileType="professor"></QuickReview>
			<ProfessorReview
				class="animated fadeInUp"
				v-for="(rating, i) in ratings"
				:key="rating.id"
				:rating="rating"
				:delay="(i+1) * 200"
			></ProfessorReview>
		</ReviewsContainer>
	</ProfileContainer>
</template>

<script>
	import Fetcher from 'Js/lib/Fetcher';
	import ProfileContainer from '../components/ProfileContainer';
	import ProfessorDetailsCard from '../components/ProfessorDetailsCard';
	import ReviewsContainer from '../components/ReviewsContainer';
	import ProfessorReview from '../components/ProfessorReview';
	import QuickReview from '../components/QuickReview';
	import hasReviews from 'Js/mixins/hasReviews';
	import { loadProfessorReviews, loadReviewsFeedbackForProfessor as loadFeedback } from 'Js/store/api';

	export default {
		name: 'Professor',
		mixins: [hasReviews],
		components: {
			ProfileContainer, ProfessorDetailsCard, ProfessorReview, ReviewsContainer, QuickReview,
		},	
		/**
		 * Fetch the professor's additional data like department and the reviews
		 * @return {Void} 
		 */
		created() {
			Fetcher.all(this);
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
			 * Return the target of the rating button
			 * @return {Object} 
			 */
			buttonTarget() {
				const {id, slug} = this.professor;
				return { 
					name: 'rateProfessor', 
	     			params:{ id, slug },
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
			dataIsReady(isReady) {
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
				const {id} = this.professor;
				const params = {
				  	filter_groups: [{
			      		filters: [
					      	{
						        key: 'professor_id',
						        value: id,
						        operator: 'eq'
					       	},
					       	{
						        key: 'approved',
						        value: 1,
						        operator: 'eq'
					       	},
				      	]
			    	}]
				};

				Promise.all([loadProfessorReviews(params), loadFeedback(id)])
				.then((res) => {
					let {reviews} = res[0].data;
					const {data: feedback} = res[1];
					this.ratingsAreReady = true;

					// Bind the feedback to the appropriate reviews
					reviews = reviews.map((review) => {
						review.feedback = feedback.filter(({review_id}) => review_id == review.id);
						return review;
					});
					this.$store.commit({
						type: 'updateTheReviewsInView',
						reviews,
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