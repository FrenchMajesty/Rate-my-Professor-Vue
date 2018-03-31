import { loadAllSchoolsData, loadAllProfessorsData } from '../store/api';

export default class Fetcher {

	/**
	 * Handle the proccess to load all schools data if it hasn't been done yet
	 * @param  {Object} vm The vue instance of the context it's invoked in
	 * @return {Void}    
	 */
	static schools(vm) {
		const {beingFetched} = vm.$store.state.school;

		if(!beingFetched) {
			vm.$store.commit('updateSchoolsDataFetchingStatus', true);

			loadAllSchoolsData().then(({data}) => {
				vm.$store.commit({
					type: 'updateSchoolsData',
					data: data.schools,
				});
			})
			.catch(error => {
				vm.$store.commit('updateSchoolsDataFetchingStatus', false);
				console.log(error);
			});
		}
	}

	/**
	 * Handle the process to load all professors data if it hasn't been done yet
	 * @param  {Object} vm The vue instance of the execution context
	 * @return {Void}    
	 */
	static profs(vm) {
		const {beingFetched} = vm.$store.state.prof;

		if(!beingFetched) {
			vm.$store.commit('updateProfsDataFetchingStatus', true);

			loadAllProfessorsData().then(({data}) => {
				vm.$store.commit({
					type: 'updateProfsData',
					data: data.profs,
				});
			})
			.catch(error => {
				vm.$store.commit('updateProfsDataFetchingStatus', false);
				console.log(error);
			});
		}
	}
}