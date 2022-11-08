package study  # Do not modify the package name
# Please implement the requested policy using Rego
# The policy and example graphs/inputs can be 
# found in the panel to the right
#
# Click the green "Run" button to evaluate your 
# policy on each of the inputs
#
# Your policy should be named final_policy, but you may 
# define additional policies to use in final_policy

final_policy {
  some i, j, k
  input.edges[i].relation == "wasAssociatedWith"
  input.edges[i].destination == "sgx#intel"
  
  input.edges[i].source == input.vertices[j].name
  input.vertices[j].type == "activity"

  input.edges[k].source == "sgx#intel"
  input.edges[k].relation == "actedOnBehalfOf"
  input.edges[k].destination == "recruiter#org"
}