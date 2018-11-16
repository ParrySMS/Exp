#include <iostream>

#define MAX 9999
#define SIZE 30
using namespace std;

class Mx {
	public:
		int mx[SIZE][SIZE];
		string nodes[SIZE];
		int node_num;

		int getIndex(string name) {
			int i;
			for(i=0; i< this->node_num; i++) {

				if( this->nodes[i].compare(name) == 0) {
					return i;
				}
			}
//			not found
			return -1;
		}

		Mx(int n,string name1[],int m,string b[][2],int cost[]) {
			int i,j;

			this->node_num = n; 
			for(i=0; i<this->node_num; ++i) {
				nodes[i] = name1[i];
				for(j=0; j<this->node_num; ++j) {
					this->mx[i][j] = MAX;
				}
			}

			for(i=0; i<m; ++i) {
				this->mx [ getIndex(b[i][0]) ][ getIndex(b[i][1]) ] = cost[i];
				this->mx [ getIndex(b[i][1]) ][ getIndex(b[i][0]) ] = cost[i];
			}

		}

		void prim() {
			int i = 0,sum = 0;
			int* flag = new int[20]();

			flag[0] = 1;

			for(i=0; i<this->node_num-1; i++) {
				int vi,vo;
				getNext(flag,vi,vo);
				sum += this->mx[vi][vo];
			}
			cout<<sum<<endl;

		}

		void prim(string name) {
			int* flag = new int[20]();
			int i;
			flag[getIndex(name)] = 1;

			cout<<"prim:"<<endl;
			for(i=0; i<this->node_num-1; i++) {
				int vi,vo;
				getNext(flag,vi,vo);
				cout<<this->nodes[vi]<<" ";
				cout<<this->nodes[vo]<<" ";
				cout<<this->mx[vi][vo]<<endl;
			}
		}

		void getNext(int* flag,int vi,int vo) {
			int i,j,min = MAX;
			for(i=0; i<this->node_num; i++) {
				if(flag[i]!=1) { //visited
					continue;
				}

				for(j=0; j<this->node_num; j++) {
					if(flag[i]==1) { //not visited
						continue;
					}

					if(mx[i][j]<min) {
						min = this->mx[i][j];
						vi = i;
						vo = j;
					}
				}
			}

			flag[j] = 1;
		}

		void kruskal() {
			cout<<"kruskal"<<endl;
			int set[SIZE];
			int i,j,k,m,vi,vo,min = MAX;

			for(i=0; i<this->node_num-1; i++) {
				set[i]=i;
			}

			for(k=0; k<this->node_num-1; k++) {
				for(i=0; i<this->node_num-1; i++) {
					for(j=0; j<this->node_num-1; j++) {
						if(this->mx[i][j] <min && set[i]!=set[j] ) {
							min = this->mx[i][j];
							vi = i;
							vo = j;
						}
					}
				}
				//merge

				for(m=0; m<this->node_num-1; m++) {
					if(set [vo] == set[m]) {
						set[m] = set[vi];
					}
				}

				cout<<this->nodes[vi]<<" ";
				cout<<this->nodes[vo]<<" ";
				cout<<this->mx[vi][vo]<<endl;
			}
		}
};

int main() {
	int i,k,n,m,cost[SIZE];
	string name,nodes[SIZE],b[SIZE][2];

	cin>>n;
	for(i=0; i<n; i++) {
		cin>>nodes[i];
	}

	cin>>m;
	for(i=0; i<m; i++) {
		cin>>b[i][0]>>b[i][1]>>cost[i];
	}

	cin>>name;

	Mx mx(n,nodes,m,b,cost);
	mx.prim();
	mx.prim(name);
	mx.kruskal();

	return 0;



}


