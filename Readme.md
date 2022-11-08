# ProProv Appendix

This repository contains the source code and other artificts for "ProProv: A Language and Graphical Tool for
Specifying Data Provenance Policies", published in the proceedings of 
The Fourth IEEE International Conference on Trust, Privacy and Security in Intelligent Systems, and Applications.

The following folders are included:

- [additional-images-and-tables](./additional-images-and-tables) contains figures and tables omitted from the paper to meet the submission page limit
    - These are described at the end of this readme

- [experiment-graphs](./experiment-graphs) contains all of the information about the experiment tasks, including the task prompt, test cases, and solutions

- [experiment-website-policy-only](./experiment-website-policy-only) contains a simplified version of the experiment website without the CodeIgniter framework that only includes the policy tasks, allowing for easy testing of the tasks (for example, questions such as the exit survey are ommitted and data collection is not performed). 
    - Can be run simply by hosting on a webserver with PHP (i.e., a local Apache server) and opening the rego or proprov pages

- [experiment-website-source](./experiment-website-source) contains the CodeIgniter source code for the experiment website as students viewed it, including all sections and data collection
    - Requires the usual CodeIgniter framework installation and database migrations

- [proprov-standalone-gui](./proprov-standalone-gui) contains the original ProProv GUI that was to be used for the experiment before it was integrated directly into the experiment website

- [proprov-website-integration](./proprov-website-integration) contains the ProProv backend that is used to evaulate ProProv policies with the experiment website
    - The source code for the `experiments-proprov.jar` files found in the [experiment-website-policy-only](./experiment-website-policy-only) and [experiment-website-source](./experiment-website-source) folders

- [training-slides](./training-slides/) contains the training slides presented in the training videos

- [training-videos](./training-videos) contains the training videos in mp4 and webm format, with vtt formatted captions

The following files are included:

- [exit-survey.md](./exit-survey.md) contains the exit survey questions

- [experiment-scenario.md](./experiment-scenario.md) contains the experiment scenario as provided to participants

- [consent-form.pdf](./consent-form.pdf) is the consent form participants signed to participate in the study

## Additional Figures and Tables

![W3C Povenance Data Model](./additional-images-and-tables/w3c-prov-dm.png?raw=true "W3C Povenance Data Model")

![ACDC Povenance Data Model](./additional-images-and-tables/acdc-prov-model.png?raw=true "ACDC Povenance Data Model")