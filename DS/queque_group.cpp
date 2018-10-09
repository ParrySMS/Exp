#include <queue>
#include <map>
#include <stack>
#include <string>
#include <math.h>
#include <iostream>
#include <iomanip>

using namespace std;


int main() {
	int i,t,n,value,data;
	int q_group_num,data_group_num;
	string op;
	map <int,int> group;
	map <int,int>::iterator it;
//	queue <int> q;
	queue <int> *qAr[10];
	bool first = true;



	cin>>t;
//	cout<<"get t"<<endl;
	for(i=0; i<t; i++) {

		cin>>n;
//		cout<<"get n"<<endl;
		for(i=0; i<n; i++) {
			cin>>value;
			group.insert(pair<int,int>(value,t));
	//		cout<<"group.insert"<<endl;
		}

	}
	
	//init
	for(i=0; i<t; i++) {
	//	cout<<"init"<<endl;
		qAr[i] = new queue <int> ;
	//	cout<<"qAr["<<i<<"]"<<"--size:"<<qAr[i]->size()<<endl;
	}


	while(1) {
		cin>>op;
		if(op.compare("STOP") == 0) {
			//clear
	//		cout<<"clean"<<endl;
			for(i=0; i<t; i++) {
				while(!qAr[i]->empty()) {
	//				cout<<"pop"<<endl;
					qAr[i]->pop();
				}
			}

			break;
		}

		if(op.compare("ENQUEUE") == 0) {
	//		cout<<"get--ENQUEUE"<<endl;
			cin>>data;

			for(i=0; i<t; i++) {

				if(qAr[i]->empty()) {

					qAr[i]->push(data);
		//			cout<<"push first"<<endl;
					break;

				} else { //check same group
		//			cout<<"check same group"<<endl;
					q_group_num = group[qAr[i]->front()];
					data_group_num = group[data];

					if(q_group_num == data_group_num) {
						qAr[i]->push(data);
			//			cout<<"push same"<<" num:"<<q_group_num<<endl;
						break;
					}

			//		cout<<"not same group"<<endl;

				}
			}

		}

		if(op.compare("DEQUEUE") == 0) {

			if(first) {
				cout<<qAr[0]->front();
				first = false;
				qAr[0]->pop();

			} else {
				for(i=0; i<t; i++) {
					if(!qAr[i]->empty()) {
						cout<<" "<<qAr[i]->front();
						qAr[i]->pop();
						break;
					}
				}
			}
		}

	}
	return 0;
}


