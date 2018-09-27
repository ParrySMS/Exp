#include <queue>
#include <map>
#include <stack>
#include <string>
#include <math.h>
#include <iostream>
#include <iomanip>
#include <stdio.h>
using namespace std;


int main() {
	int i,t,n,value,data;
	int q1_group_num,q2_group_num,data_group_num;
	string op;
	map <int,int> group;
	map <int,int>::iterator it;
	queue <int> q1,q2;
	bool has;

	cin>>t;
	while(t--) {
		cin>>n;
		for(i=0; i<n; i++) {
			cin>>value;
			group.insert(pair<int,int>(value,t));
		}
	}


	while(1) {
		cin>>op;
		if(op.compare("STOP") == 0) {
			while(!q2.empty()) {
				cout<< q2.front()<<endl;
				q2.pop();
			}
			break;
		}

		if(op.compare("ENQUEUE") == 0) {
			cin>>data;
			if(q1.empty()) {
				q1.push(data);
//				cout<<"push first";

			} else { //check same group

				it = group.find(data);
				data_group_num = it->second;

				q2 = q1;//keep q1

				has = false;
				while(!q2.empty()) {
					it = group.find(q2.front());
					q2_group_num = it->second;

					if(data_group_num == q2_group_num) {
//						cout<<"has";
						has = true;
						//push again make a new queue
						break;
					}

					q2.pop();
				}

				//clear q2;
				while(!q2.empty()) {
					q2.pop();
				}

				if(has) {//push again make a new queue

					it = group.find(q1.front());
					q1_group_num = it->second;
					//put q1 in q2
					while(!q1.empty()) {
						if(!q2.empty()) {//check q2 last one
							it = group.find(q2.front());
							q2_group_num = it->second;
						}

						if(!q2.empty()
						        && q2_group_num == data_group_num //last one same group
						        && q1_group_num != data_group_num) {//next one another group
							//so it is end of last group
							q2.push(data);
						} else if(q1.size()==1 && q1_group_num == data_group_num) {//all is same group
							q2.push(q1.front());
							q1.pop();
							q2.push(data);
						} else {
							//let other in
							q2.push(q1.front());
							q1.pop();
						}
					}

				} else { //not has group
					q1.push(data);
					q2 = q1;
				}
				
				//store back data
				q1 = q2;


			}
		}

	}


	return 0;

}



