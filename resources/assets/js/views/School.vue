<template>
	<ProfileContainer v-if="school">
		<DetailsCard 
			:school="school"
			:ratings="ratings"
		></DetailsCard>
		<ReviewsContainer 
			:is-ready="ratingsAreReady"
			:has-ratings="hasRatings"
			:buttonTarget="buttonTarget"
			profileType="school" 
		>
			<QuickReview :submit="finishReview" profileType="school"></QuickReview>
			<SchoolReview
				class="animated fadeInUp"
				v-if="hasRatings"
				v-for="(rating, i) in ratings"
				:key="rating.id"
				:rating="rating"
				:delay="(i+1) * 200"
			></SchoolReview>
		</ReviewsContainer>
	</ProfileContainer>
</template>

<script>
	import Fetcher from 'Js/lib/Fetcher';
	import ProfileContainer from '../components/ProfileContainer';
	import ReviewsContainer from '../components/ReviewsContainer';
	import SchoolReview from '../components/School/SchoolReview';
	import QuickReview from '../components/QuickReview';
	import DetailsCard from '../components/School/DetailsCard';
	import hasReviews from 'Js/mixins/hasReviews';
	import { loadSchoolReviews } from 'Js/store/api';

	export default {
		name: 'School',
		mixins: [hasReviews],
		components: {
			ProfileContainer, QuickReview, SchoolReview, ReviewsContainer, DetailsCard,
		},
		created() {
			Fetcher.schools(this).profs(this);
		},
		data() {
			return {
				/**
				 * The state of readiness of the ratings
				 * @type {Boolean}
				 */
				ratingsAreReady: true,
			};
		},
		computed: {
			/**
			 * Check if the school's data is ready
			 * @return {Boolean} 
			 */
			dataIsReady() {
				return this.$store.getters.schoolDataIsReady;
			},

			/**
			 * Check if there are any ratings
			 * @return {Boolean} 
			 */
			hasRatings() {
				return this.ratings.length > 0;
			},

			/**
			 * Return the target of the rating button
			 * @return {Object} 
			 */
			buttonTarget() {
				const {id, slug} = this.school;
				return { 
					name: 'rateSchool', 
	     			params:{ id, slug },
	     		};
			},

			/**
			 * Get all of the ratings for this school
			 * @return {Array} 
			 */
			ratings() {
				return this.$store.state.reviews.inView;
			},

			/**
			 * Find the school in the store with the given slug
			 * @return {Object|Void} 
			 */
			school() {
				const {fullSchoolWithSlug} = this.$store.getters;
				const {slug} = this.$route.params;

				if(this.dataIsReady) {
					return fullSchoolWithSlug(slug);
				}
			},
		},
		watch: {
			/**
			 * When the data is ready and no school with the given slug exists then redirect
			 * @param  {Boolean} isReady The value of the 'dataIsReady' computed property
			 * @return {Void}          
			 */
			dataIsReady(isReady) {
				if(isReady && !this.school) {
					this.$router.push({name: 'notFound'});
				}

				if(isReady && this.school) {
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
				const {id, slug} = this.school;
				this.$router.push({name: 'rateSchool', params: {id, slug}});
			},

			/**
			 * Make a request to fetch the approved reviews for this school
			 * @return {Void} 
			 */
			loadReviews() {
				const params = {
				  	filter_groups: [{
			      		filters: [
					      	{
						        key: 'school_id',
						        value: this.school.id,
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

				loadSchoolReviews(params).then(({data}) => {
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
			},
		},
	}
</script>