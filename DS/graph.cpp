#include <iostream>
#include <string>
#include <cstring>
using namespace std;

class Info {
	public:
		char node_name;
		int node_value;
		Info(char name ,int value) {
			node_name = name;
			node_value = value;
		}
};

class Node {
	public:
		int index;
		Node* next;
		Info* info;
		Node(Info* i) {
			next = NULL;
			info = i;
		}

		~Node() {
			if(next !=NULL) {
				delete[] next;
			}

			if(info !=NULL) {
				delete[] info;
			}
		}
};

class List {
	public:
		Node *head;
		int len;
		void setHead(Node* node) {
			head = node;
			len = 1;
		}
		List() {
			head = NULL;
			len = 0;
		}
		~List();

//		int insert(int i ,Node* node);
		int insert(Node* node);
		void show();
};

List::~List() {
	len = 0;
	delete[] head;
}

void List::show() {
	Node *p;
	p = head;

	cout<<p->info->node_name;
	while(1) {

		if(p->next == NULL) {
			cout<<"-^"<<endl;
			break;
		}

		p = p->next;
		cout<<"-"<<p->index;
	}
}

int List::insert(Node* node) {

	int index;
	Node *p;
	p = head;

	for(index=1; index<len; index++) {
		p=p->next;
		if(p==NULL) {
			break;
		}
	}//last node

	p->next = node;

	len++;

	return 1;
}




int main() {
	Node* node;
	List* graph_ar;
	char* node_ar;
	int t,n,k,i,value;
	char name,start,end;
	int getIndex(char value, char* ar);

	cin>>t;
	while(t--) {
		cin>>n>>k;

		graph_ar = new List [n];
		node_ar = new char [n];

		for(i=0; i<n; i++) {
			cin>>name;
			node = new Node(new Info(name,0));
			node->index = i;
			graph_ar[i].setHead(node);
			node_ar[i] = name;
		}

		while(k--) {

			cin>>start>>end;

			// get head
			i = getIndex(start,node_ar);
			if(i!=-1) {
				node = new Node(new Info(end,0));
				node->index = getIndex(end,node_ar);
				graph_ar[i].insert(node);
			}
		}//end k side
		
		//echo
		for(i=0; i<n; i++) {
			cout<<i<<" ";
			graph_ar[i].show();
		
		}
		
//		for(i=0; i<n; i++) {
//			graph_ar[i].~List();
//		}
		


	}//end while
}

int getIndex(char value, char* ar) {
	int i,len;
	len = strlen(ar);
	for(i=0; i<len; i++) {
		if(ar[i]==value) {
			return i;
		}
	}

	return -1;
}






