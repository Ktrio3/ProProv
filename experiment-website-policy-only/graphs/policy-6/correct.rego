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
  some i
    
  input.vertices[i].type == "dataEntity"
  not p2(i)
}

p2(i){
  some j, k
  input.vertices[i].name == input.edges[j].source
  input.edges[j].relation == "wasAttributedTo"
    
  input.vertices[k].name == input.edges[j].destination
  p3(k)
}

p3(k){
  input.vertices[k].type == "accountAgent"
}