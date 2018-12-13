#include <iostream>
#include <queue>
#include <iomanip>
#include <stdio.h>
#include <stdlib.h>
//#include <fstream>
//#include <time.h>
//#include <ctime>


using namespace std;

const bool ECHO_MAP = false;//����ʼ���ڽӾ���
const bool ECHO_ADDED_FLOW = false;//���ÿ�μ��ص�����
const bool ECHO_MAX_FLOW = true;//��������
const bool ECHO_TIME = false;
//const int TEST_TIMES = 10;
const int NULL_NODE = -1;
const int SOURCE_NODE = -2;
const int MAX = 2000;
const int MAX_C = 50;
const int MAX_E = 2000;

//�򵥵Ľڵ���������ݽṹ
class Node {
	public:
		int pre ;//ǰ�ڵ�
		int flow  ;//����
		bool is_back ;//�Ƿ񷴱�

		void init() {
			pre = NULL_NODE;//ǰ�ڵ�
			flow = 0 ;//����
			is_back = false;//�Ƿ񷴱�
		}
};


void getRandMap(int **mx_c,int n,int e) ;//����һ�������ͼ
void echoMx(int **mx,int x,int y) ;//���һ������
void initNode(Node node[MAX],int n);//��ʼ���ڵ��������
inline int getRand(int a ,int b) {//��������[a,b]�ϵ������
	return (int) ( ((double)rand()/RAND_MAX)*(b-a) + a);
};

//todo ����һ�������ͼ
void getRandMap(int **mx,int n,int e) {
	int i,j,n1,n2;
	int end_num = 10;
//	srand((int)clock());

	//init 0
	for(i=0; i<n; i++) {
		for(j=0; j<n; j++) {
			mx[i][j] = 0;
		}
	}

	//filled rand
	for(i=0; i<e-2*end_num; i++) {
		n1 = getRand(end_num,n-2-end_num);
		n2 = getRand(end_num,n-2-end_num);
		mx[n1][n2] = getRand(0,50);
	}

	//start-end-flow
	for(i=0; i<end_num; i++) {
		mx[0][i+1] = getRand(0,MAX_C);
		mx[end_num-1][end_num-2-i] = getRand(0,MAX_C);
	}

}

//���һ������
void echoMx(int** mx,int x,int y) {
	int i,j;
	for(i=0; i<x; i++) {
		for(j=0; j<y; j++) {
			cout<<mx[i][j]<<" ";
		}
		cout<<endl;
	}
}

void initNode(Node node[MAX],int n) {
	int i;
	for(i=0; i<n; i++) {
		node[i].init();
	}

}

int main() {
	int i,j,k,t,node_num,edge_num,head,remaining,min_flow;
	queue<int> q;//��·���Ķ���
	
//	clock_t time_start, time_end,time,time_sum = 0;

	int **mx_c;//�������� ���ڽӾ���
	int **mx_f;//���������


	cin>>t; //���Դ���
	for(k=1; k<=t; k++) {
		cin>>node_num>>edge_num;
//	node_num = 50;
//	edge_num = 500;

		mx_c = new int*[node_num]; //��ʼ������
		mx_f = new int*[node_num];
		for(i=0; i<node_num; i++) {
			mx_c[i] = new int[node_num]();
			mx_f[i] = new int[node_num]();
			for(j=0; j<node_num; j++) {
				mx_c[i][j]=0;
				mx_f[i][j]=0;
			}
		}


		int v1,v2,c;
		for(i=0; i<edge_num; i++) { //��¼���ӵ�������
			cin>>v1>>v2>>c;
			//�����Ǵ�1��ʼ��
			mx_c[v1-1][v2-1] = c;
		}
		//��ʼ��ͼ
//	getRandMap(mx_c,node_num,edge_num);





		if(ECHO_MAP) {
			cout<<"c:"<<endl;
			echoMx(mx_c,node_num,node_num);
			cout<<"f:"<<endl;
			echoMx(mx_f,node_num,node_num);
		}

		min_flow = MAX;//��ʼ����С��
		Node node[MAX]; //�ڵ��������
		initNode(node,node_num);
		node[0].pre = SOURCE_NODE;//ԭ��

		q.push(0);//ԭ�㿪ʼ

//		time_start = clock();

		while(!q.empty()) {//�������
			//ȡһ�����׳��� �ֱ�������߷���
			head = q.front();
			q.pop();

			//���� ǰ���
			for(j=0; j<node_num; j++) {
				//��·�����ѱ�ǵĲ���
				if(mx_c[head][j] == 0 || node[j].pre != NULL_NODE) {
					continue;
				}

				//������δ���
				remaining = mx_c[head][j] - mx_f[head][j];//�����������
				if(remaining>0) {
					min_flow = remaining < min_flow ? remaining:min_flow;
					//����
					node[j].flow = min_flow;
					node[j].pre = head;
					q.push(j);
				}
			}

			//����
			for(i=0; i<node_num; i++) {
				if(mx_c[i][head] == 0 || node[i].pre != NULL_NODE ) {
					continue;
				}

				//ָ����δ���
				if(mx_f[i][head]>0) {//���������� ��Ƿ���
					min_flow = mx_f[i][head] < min_flow ? mx_f[i][head]:min_flow;
					//���
					node[i].flow = min_flow;
					node[i].pre = head;
					node[i].is_back = true;
					q.push(i);
				}
			}

			//end
			if(node[node_num-1].pre >= 0) { //���Ļ���Ѿ������ �ҵ�һ�� ���м���
				//��¼·��
				int * path = new int [node_num];
				int pre;

				for(j = node_num-1,i=0; node[j].pre != SOURCE_NODE; i++,j=pre) { //�Ӻ���ǰ ��û��ͷ
					path[i] = j;
					pre = node[j].pre;//��ǰ��
					if(node[j].is_back) { //����
						mx_f[j][pre] -= min_flow; //ԭָ��߼�ȥ

					} else { //����
						mx_f[pre][j] += min_flow; //�������
					}
				}

				if(ECHO_ADDED_FLOW) { //�����η��������
					for(j=i-1; j>=0; j--) {
						if(j) cout<<path[j]+1<<"-->";
						else  cout<<path[j]+1<<"  ";
					}
					cout<<"flow:"<<min_flow<<endl;
				}

				//reset
				min_flow = MAX;
				initNode(node,node_num);
				//clear queue
				q.push(0);//Դ�������
				while(q.front()!=0)
					q.pop();//�������ڵ��������

				node[0].pre = SOURCE_NODE;//ԭ��

				delete []path;

			}
		}//end while
		while(!q.empty())
			q.pop();

//	time_end = clock();

		if(ECHO_MAX_FLOW) {
			int max_flow = 0;
			for(i=0; i<node_num; i++) {
				max_flow += mx_f[0][i];
			}
			cout<<"Case "<<k<<": "<<max_flow<<endl;
		}

		if(ECHO_TIME) {

//			time = time_end - time_start;
//			time_sum += time;
//			cout<<"time:"<<time<<" ms"<<endl;
		}

		for(i=0; i<node_num; i++) {
			delete [] mx_c[i];
			delete [] mx_f[i];
		}
		delete []mx_c;
		delete []mx_f;
	}
	if(ECHO_TIME) {
//		cout<<setiosflags(ios::fixed)<<setprecision(2);
//		cout<<"avg-time:"<<(double)time_sum/TEST_TIMES<<" ms"<<endl;
	}


	return 0;
}
