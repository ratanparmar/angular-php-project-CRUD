import { Component, OnInit,ViewChild } from '@angular/core';
import { ApiService } from '../api.service'
import { Policy } from '../policy';
import { stringify } from '@angular/compiler/src/util';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css']
})
export class DashboardComponent implements OnInit {

  @ViewChild('f') formValues;
  policies : Policy[];
  selectedPolicy : Policy = {id:null,number: null,name:'', amount: null}; 
  constructor(private apiService : ApiService) { }
  
  createOrUpdatePolicy(form: any){
    if(this.selectedPolicy && this.selectedPolicy.id){
      form.value.id = this.selectedPolicy.id;
      this.apiService.updatePolicy(form.value).subscribe((policy: Policy)=>{
        console.log("Policy updated",policy);
        this.getPolicies();
      });   
    }else
    
    this.apiService.createPolicy(form.value).subscribe((policy:Policy)=>{
      console.log("Policy created, ", policy);
      this.getPolicies();
      this.formValues.resetForm();
    })
  }

  selectPolicy(policy : Policy){
    this.selectedPolicy = policy;
  }

  deletePolicy(id : number){
    this.apiService.deletePolicy(id).subscribe((policy: Policy)=>{
      console.log("Policy deleted, ", policy);
      this.getPolicies();
    })
  }



  ngOnInit() {
   this.getPolicies();
    
    
  }

  getPolicies () {
    this.apiService.readPolicies().subscribe((policies:Policy[])=>{
      this.policies = policies;
      //console.log(this.policies);
    });
  }
}
