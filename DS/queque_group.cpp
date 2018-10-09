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
	int q_group_num,data_group_num;
	string op;
	map <int,int> group;
	map <int,int>::iterator it;
	queue <int> q,q2,*p;
	bool has=true;


	cin>>t;
	while(t--) {
		cin>>n;
		for(i=0; i<n; i++) {
			cin>>value;
			group.insert(pair<int,int>(value,t));
		}
	}

	p = &q;
	while(1) {
		cin>>op;
		if(op.compare("STOP") == 0) {
	
			while(!q.empty()) {
				q.pop();
			}
			break;
		}

		if(op.compare("ENQUEUE") == 0) {
			cin>>data;
			if(p[i].empty()) {
				p[i].push(data);
//				cout<<"push first";

			} else { //check same group

				for(i=0; i<t; i++) {

					q_group_num = group[p[i].front()];
					data_group_num = group[data];

					if(q_group_num == data_group_num) {
						p[i].push(data);
						break;
					}

				}
			}

		}

		if(op.compare("DEQUEUE") == 0) {

			if(has) {
				cout<<p[0].front();
				has = false;
				p[0].pop();

			} else {
				for(i=0; i<t; i++) {
					if(!p[i].empty()) {
			//			cout<<" "<<p[i].front();
						p[i].pop();
						break;
					}
				}
			}
		}

	}
	if(!q.empty()) {
		q.pop();
	}
	delete p;
	return 0;
}


