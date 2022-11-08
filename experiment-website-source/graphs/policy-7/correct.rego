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
  not p1
}

p1{
  some i, j, k
    
  input.edges[i].source == "filtered#org"
  input.edges[i].relation == "wasDerivedFrom"
  
  input.edges[i].destination == input.vertices[j].name
  input.vertices[j].type == "dataEntity"

  input.vertices[j].name == input.edges[k].source
  input.edges[k].relation == "wasAttributedTo"
  input.edges[k].destination != "recruiter#org"
  input.edges[k].destination != "registrar#usf"
}