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
  # Define your policy here
  some i
  input.edges[i].relation == "wasDerivedFrom"
  input.edges[i].source == "filtered#org"
  input.edges[i].destination == "students#usf"
}