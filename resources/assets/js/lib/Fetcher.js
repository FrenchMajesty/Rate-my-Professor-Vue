import { 
	loadAllSchoolsData,
	loadAllProfessorsData,
	loadAllReviewTags,
	loadUserIpAddress,
	loadAllDeptsData } from '../store/api';

export default class Fetcher {

	/**
	 * Load everything can be loaded with this module
	 * @param  {Vue} vm The vue instance it's invoked in
	 * @return {Fetcher}    
	 */
	static all(vm) {
		return this.schools(vm).profs(vm).depts(vm).tags(vm).ip(vm);
	}

	/**
	 * Handle the proccess to load all schools data if it hasn't been done yet
	 * @param  {Vue} vm The vue instance of the context it's invoked in
	 * @return {Fetcher}    
	 */
	static schools(vm) {
		const {beingFetched} = vm.$store.state.school;
		const status = 'updateSchoolsDataFetchingStatus';

		if(!beingFetched) {
			vm.$store.commit(status, true);

			loadAllSchoolsData().then(({data}) => {
				vm.$store.commit({
					type: 'updateSchoolsData',
					data: data.schools,
				});
			})
			.catch(error => {
				vm.$store.commit(status, false);
				console.log(error);
			});
		}

		return this;
	}

	/**
	 * Handle the process to load all professors data if it hasn't been done yet
	 * @param  {Vue} vm The vue instance of the execution context
	 * @return {Fetcher}    
	 */
	static profs(vm) {
		const {beingFetched} = vm.$store.state.prof;
		const status = 'updateProfsDataFetchingStatus';

		if(!beingFetched) {
			vm.$store.commit(status, true);

			loadAllProfessorsData().then(({data}) => {
				vm.$store.commit({
					type: 'updateProfsData',
					data: data.profs,
				});
			})
			.catch(error => {
				vm.$store.commit(status, false);
				console.log(error);
			});
		}

		return this;
	}

	/**
	 * Handle the process to load all department datas if it hasn't been done yet
	 * @param  {Vue} vm The vue instance of the execution context
	 * @return {Fetcher}    
	 */
	static depts(vm) {
		const {beingFetched} = vm.$store.state.dept;
		const status = 'updateDeptsDataFetchingStatus';

		if(!beingFetched) {
			vm.$store.commit(status, true);

			loadAllDeptsData().then(({data}) => {
				vm.$store.commit({
					type: 'updateDeptsData',
					data: data.depts,
				});
			})
			.catch(error => {
				vm.$store.commit(status, false);
				console.log(error);
			});
		}

		return this;
	}

	/**
	 * Handle the process to load all review tags if it hasn't been done yet
	 * @param  {Vue} vm The vue instance of the execution context
	 * @return {Fetcher}    
	 */
	static tags(vm) {
		const {beingFetched} = vm.$store.state.tags;
		const status = 'updateTagsDataFetchingStatus';

		if(!beingFetched) {
			vm.$store.commit(status, true);

			loadAllReviewTags().then(({data}) => {
				vm.$store.commit({
					type: 'updateTagsData',
					data,
				});
			})
			.catch(error => {
				vm.$store.commit(status, false);
				console.log(error);
			});
		}

		return this;
	}

	/**
	 * Fetch the user's IP address
	 * @param  {Vue} vm The vue instance of the execution context
	 * @return {Fetcher}    
	 */
	static ip(vm) {
		const {beingFetched} = vm.$store.state.ip;

		if(!beingFetched) {
			vm.$store.commit('updateIpAddress', {beingFetched: true});
			loadUserIpAddress().then(({data: ipAddress}) => {
				vm.$store.commit('updateIpAddress', {ipAddress, lastUpdated: Date.now()});
			})
			.catch(error => {
				console.log(error);
				vm.$store.commit('updateIpAddress', {beingFetched: false});
			});
		}

		return this;
	}
}